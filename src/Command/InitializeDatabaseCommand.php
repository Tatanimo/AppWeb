<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressIndicator;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'init:db',
    description: 'Génère la base de données avec les fichiers SQL nécessaires au bon fonctionnement',
)]
class InitializeDatabaseCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $noInteraction = $input->getOption('no-interaction');

        $io->warning("Attention ! Une base de données existante sera supprimée si vous souhaitez générer une nouvelle base de données ! Ne prenez pas en rigueur l'avertissement si aucune base de données est déjà existante pour l'application.");
        $result = $io->confirm('Êtes-vous sûr de vouloir générer la base de données ?', $noInteraction ? true : false);

        if (!$result) {
            $io->error('Annulation de la procédure de génération de la base de données');
            return Command::FAILURE;
        }

        $io->writeln(['Création de la base de données', '==============================']);
                
        // Execute D:D:D --force
        $io->info("Exécution de la suppression d'une potentiel base de données");
        $delete = new ArrayInput([
            'command' => 'd:d:d',
            '--force' => true
        ]);
        $delete->setInteractive(false);
        $this->getApplication()->doRun($delete, $output);

        // Execute D:D:C
        $io->info("Exécution de la création de la base de données");
        $create = new ArrayInput([
            'command' => 'd:d:c',
        ]);
        $this->getApplication()->doRun($create, $output);

        // Execute D:M:M
        $io->info("Exécution de la migration");
        $migrate = new ArrayInput([
            'command' => 'd:m:m',
            '--no-interaction' => true
        ]);
        $migrate->setInteractive(false);
        $this->getApplication()->doRun($migrate, $output);

        // Process pour ajouter les fichiers SQL
        $io->info("Procédure d'importation des fichiers SQL");
        $process = new Process([
            'mysql',
            '-u', $_ENV['DATABASE_USER'],
            '--default-character-set=utf8',
            $_ENV['DATABASE_NAME'],
            '-e', 'SOURCE database/regions.sql; SOURCE database/departments.sql; SOURCE database/cities.sql; SOURCE database/family_animals.sql; SOURCE database/category_animals.sql; SOURCE database/triggers.sql;'
        ]);
        $io->success($process->getCommandLine());
        $process->start(null, ['MYSQL_PWD' => $_ENV['DATABASE_PASSWORD']]);
        
        $this->processProgress($process, $output);

        $io->success('Les fichiers SQL ont bien étaient importés.');

        // Process D:L:F 
        $io->info('Procédure de génération des fixtures');
        $process = new Process([
            'php',
            'bin/console',
            'd:f:l',
            '--append'
        ]);
        $process->start();
        $this->processProgress($process, $output);

        $io->success('Les fixtures ont bien été générées.');

        $io->success("La génération de la base de données et de ses données de test a été effectuée avec succès !");

        return Command::SUCCESS;
    }
    
    protected function processProgress($process, $output){
        // Barre de progression
        $progressIndicator = new ProgressIndicator($output, 'verbose', 100, ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇']);
        $progressIndicator->start('En attente...');

        while ($process->isRunning()) {
            $progressIndicator->advance();
            usleep(200000);
        }

        // Vérifier si le process a été un succès
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $progressIndicator->finish('Terminer');
    }
}
