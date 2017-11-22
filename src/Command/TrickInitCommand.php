<?php
namespace App\Command;

use App\Manager\GroupManager;
use App\Manager\TrickImageManager;
use App\Manager\TrickManager;
use App\Manager\VideoManager;
use App\Upload\FileUploader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class TrickInitCommand extends ContainerAwareCommand
{
    private $trickManager;
    private $videoManager;
    private $imageManager;
    private $groupManager;

    public function __construct($name = null,
        TrickManager $trickManager,
        TrickImageManager $trickImageManager,
        VideoManager $videoManager,
        GroupManager $groupManager
    )
    {
        parent::__construct($name);
        $this->trickManager = $trickManager;
        $this->imageManager = $trickImageManager;
        $this->videoManager = $videoManager;
        $this->groupManager = $groupManager;
    }

    protected function configure()
    {
        $this
            ->setName('app:generate-tricks')
            ->setDescription('Génère les figures de base en BDD')
            ->setHelp('Cette commande génère des figures en BDD à partir du fichier base_tricks.yml dans project_data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(array(
            '',
            'Trick Generator',
            ''
        ));

        // Directories setup
        $data_project_dir = $this->getContainer()->get('kernel')->getRootDir() . '/project_data/';
        $upload_dir = $this->getContainer()->get('kernel')->getRootDir() . '/../public/' . FileUploader::ASSET_PATH;

        // Definition file parsing
        $tricks = Yaml::parse(file_get_contents( $data_project_dir . 'base_tricks.yml'));

        foreach ($tricks as $trick_data)
        {
            // Trick Management
            $trick = $this->trickManager->new();
            $trick->setName($trick_data['name']);
            $trick->setDescription($trick_data['description']);
            $trick->setGroup($this->groupManager->getByName($trick_data['group']));

            // Creating base images
            foreach ($trick_data['trickImages'] as $key => $image_data)
            {
                $image = $this->imageManager->new();

                // Copying files to the uploads dir
                $output->writeln('<info>Copying File </info>' . $image_data . ' to ' . $upload_dir );
                copy($data_project_dir . $image_data, $upload_dir . $image_data);

                // Image entity setting
                $image->setFilename($upload_dir . $image_data);
                $image->setAlt($image_data);
                $image->setUrl(FileUploader::ASSET_PATH . $image_data);

                $output->writeln('<info>Generating TrickImage entity </info>');

                // Trick relation
                $trick->addTrickImage($image);
                $this->imageManager->persistOnly($image);

                $output->writeln('<comment>Image ajoutée </comment> ' . $image_data);
            }

            // Creating base videos
            foreach ($trick_data['videos'] as $key => $video_data)
            {
                $video = $this->videoManager->new();
                $video->setSourceId($video_data);

                $output->writeln('<info>Generating Video entity </info>');

                $trick->addVideo($video);
                $this->videoManager->persistOnly($video);

                $output->writeln('<comment>Vidéo ajoutée </comment> ' . $video_data);
            }

            $this->trickManager->persist($trick);

            $output->writeln(array(
                '<comment>Figure ' . $trick->getName() . ' ajoutée</comment>',
                '<comment>----------------------------------------</comment>'
                ));

        }

        $output->writeln(array(
            '<comment>DONE !</comment>'
            ));
    }
}