<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Trovit\Bundle\UserBundle\Entity\Repository\RedisUserRepository;
use Trovit\Bundle\UserBundle\Entity\User;
use AppBundle\Service\PredisClient;
use AppBundle\Factory\RedisUserFactory;

class LoadInitialDataCommand extends Command
{
    private $redis;

    public function __construct(PredisClient $client)
    {
        $this->redis = $client;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:load-initial-data')
             ->setDescription('Populate redis database with users.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln([
            'Initial Data Generator',
            '======================',
            '',
        ]);

        $users = $this->getUsersData();

        $user_factory = new RedisUserFactory($this->redis);
        $users = $user_factory->createList($users);

        foreach($users as $user){
            $output->writeln("Username: {$user->getUsername()} Pass: {$user->getPassword()}");

        }

        $output->writeln("End");
    }

    private function getUsersData()
    {
        $users = array(
            array('username' => 'demogorgon', 'password' => 'demogorgonpass'),
            array('username' => 'freddy', 'password' => 'freddypass'),
            array('username' => 'whitewalker', 'password' => 'whitewalkerpass'),
            array('username' => 'hannibal', 'password' => 'hannibalpass'),
            array('username' => 'michaelmeyers', 'password' => 'michaelmeyerspass'),
            array('username' => 'jason', 'password' => 'jasonpass'),
            array('username' => 'leatherface', 'password' => 'leatherfacepass'),
            array('username' => 'pennywise', 'password' => 'pennywisepass')
        );
        return $users;
    }
}

