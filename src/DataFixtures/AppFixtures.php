<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\Chat;
use App\Entity\Group;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var array
     */
    private $groups = ['niveau facile', 'niveau moyen', 'niveau difficile'];

    /**
     * @var array
     */
    private $tricks = [
        [
            'group' => 2,
            'name' => 'Frontside 720',
            'description' => "Le Frontside 7, comment ça marche? La phase d’approche consiste à arriver bien fléchi sur 
            le kicker, la planche bien à plat, les épaules dans l’axe de la board, le regard fixé sur le bout du kicker.
            Ensuite l'impulsion se fait à 2 pieds au bout du kicker. Ne pas pousser trop fort aux premiers essais au 
            risque d’être déséquilibré. Donc impulsion à 2 pieds, en lançant la rotation avec les épaules comme un 5.4 
            front mais il faut les lancer plus vite et donc plus fort, à affiner selon la taille du saut.
            Pour un Frontside 720, on peut avoir une impulsion bien à plat,  en appui léger sur les talons ou encore en 
            appuie pointe de pieds, suivant le style qu'on veut donner à son tricks et surtout suivant comme on se sent 
            le plus à l’aise de faire. Mais surtout il ne faut déraper le moins possible sur le kicker pour ne pas 
            perdre d’élan, en particulier sur une table de park. Pour que la rotation se fasse bien à plat il faut 
            lancer le mouvement avec  les épaules à l’horizontale et la tête qui va vers l’épaule avant. Pour désaxer, 
            c’est la tête qui va chercher à twister le mouvement et les épaules ne seront plus à l’horizontale. 
            Dès que l’on est en l’air il faut se regrouper et grabber. Pour commencer je conseille le Melon .
             Une fois que l’on maitrise bien le mouvement on peut changer de grab. Dans tous les cas, 
            la main de libre va chercher à emmener la rotation et aider à contrôler la vitesse à laquelle on tourne.
            Enfin pour terminer il faut aller chercher la réception du regard par dessus l’épaule avant : on 
            l’aperçoit après 3/4 de tour puis très bien après le premier 360. À ce moment là, ne pas la fixer et 
            continuer de regarder vers l'épaule pour continuer à emmener la rotation. Enrouler bien le mouvement pour 
            continuer à tourner toujours en allant chercher du regard et en s’aidant de la main qui ne grave  pas. 
            À partir de maintenant tout va ce passer comme pour la fin d’un 3.6 front.",
            'video' => ['https://www.youtube.com/embed/1vtZXU15e38'],
            'picture' => ['fs1.jpg', 'fs2.jpg', 'fs3.jpg']
        ],
        [
            'group' => 2,
            'name' => 'switch back 540',
            'description' => "Avant tout, il faut bien maitriser le fait de rider en switch avec aisance ainsi que le 
            switch 180 back pour l’arrivé sur le kick et les 360 front pour la fin de la rotation et le replaquage.La 
            phase d’approche consiste à arriver bien fléchi sur le kicker, la planche bien à plat, les épaules dans 
            l’axe de la board, le regard fixé sur le bout du kicker. L’impulsion se fait à 2 pieds au bout du kicker, 
            en lançant la rotation avec les épaules. Ne pas pousser trop fort aux premiers essais au risque d’être 
            déséquilibré. La vitesse à laquelle il faut lancer les épaules pour lancer la rotation dépend de la taille 
            du saut évidement… Le mieux est de commencer par un saut d’environ 5m, sa suffit pour tourner ce tricks. 
            Pour que la rotation se fasse à plat, il faut lancer le mouvement avec  les épaules à l’horizontale. Le 
            regard se porte par dessus l’épaule, le menton au niveau de l’épaule. Pour désaxer, c’est la tête qui va 
            chercher à twister le mouvement, et les épaules ne seront plus à l’horizontale. Dès que l’on est en l’air, 
            se regrouper et grabber. On vous conseille le Melon Grab pour commencer, c’est le plus simple avec cette 
            rotation. Il faut aller chercher la rotation du regard par dessus l’épaule avant. On aperçoit la reception 
            après 270° et a partir de ce moment là c’est tout comme la fin d'un bon vieux 360 front. Il faut donc fixer
             des yeux la réception et ne pas la lâcher. Le mouvement est fini avec la tête tandis qu’il continue avec 
             les épaules et le bas du corps restés en retard pour aller s’aligner vers la réception. Pour atterrir, 
             il faut ramener le bas du corps dans l’axe de la réception en se regroupant si on a besoin d’accélérer 
             le mouvement. On détend ses jambes pour aller chercher la réception puis amortir sur les deux jambes au 
             contact du sol. Les épaules doivent être dans l’axe de la board ou légèrement en retard pour arrêter la 
             rotation, surtout si on sent que l’on tournait trop vite, ça évite la sur-rotation. Regardez devant vous 
             une fois que vous avez fini d’amortir.",
            'video' => ['https://www.youtube.com/embed/wDoHk1Y6c-w'],
            'picture' => ['sb1.jpg']
        ],
        [
            'group' => 0,
            'name' => 'Ollie',
            'description' => "Le Ollie est une impulsion  avec déformation de la planche qui permet de faire un saut, 
            comme un ollie de skate, mais en beaucoup plus facile car les deux pieds sont attachés sur la board.
            Conseils pour réaliser à un ollie en snowboard. Le Ollie peut se décomposer en plusieurs phases, la phase 
            d’approche consiste à avoir sa planche la plus à plat possible ou légèrement sur la carre; le regard pointé 
            vers le spot (l’endroit où on veut décoller). Les jambes sont fléchies, prêtes à donner une impulsion. 
            Ensuite pour déclencher le Ollie, il faut tirer sur la jambe avant tout en appuyant sur la jambe arrière 
            pour déformer la planche et aller chercher le pop de son snowboard (le «rebond» de la planche). On peut 
            s'aider des bras en les dépliants comme un oiseau qui cherche à s'envoler ;). Dés que l’on sent qu’on 
            décolle, il faut regrouper les jambes et les bras pour gagner en stabilité, le regard cherche déjà 
            l’endroit où on va aller atterrir tout en essayant de profiter du moment présent… Enfin pour atterrir, 
            il faut légèrement détendre les jambes pour aller chercher le sol tout en préparant l’amorti, c’est à dire 
            forcer sur les jambes qui servent d’amortisseur. Bien plier les genoux sans se laisser assoir par la force 
            de gravité.",
            'video' => ['https://www.youtube.com/embed/kOyCsY4rBH0'],
            'picture' => ['ol1.jpeg', 'ol2.jpeg', 'ol3.jpeg']
        ],
        [
            'group' => 0,
            'name' => 'Grab',
            'description' => "Le grab, comment ça marche? Il faut d'abord faire un saut, un simple ollie par exemple 
            comme on peut le voir sur le tuto du ollie. Bien plier les jambes une fois en l’air pour se regrouper, et 
            aller chercher la planche avec la main. Attention il ne faut pas que le buste se casse en deux pour aller 
            chercher la board : ce sont bien les genoux qui remontent pour amener la board vers la main. Il existe 6 
            grabs de base (Indy : la main arrière vient graber la carre frontside entre les pieds. Sur un saut droit 
            c’est un Indy Grab, sur un hip ou un quarter en front c’est un frontside indy ou frontside grab alors que 
            sur un saut en back ça sera un backside Indy // Mute : la main avant grabbe la carre 
            frontside entre les pieds. // Nose grab : la main avant grabbe le nose. // Melon : la main avant grabbe la 
            carre bakside entre les talons. En désaxant le corps et la board cela peut faire un Method ou un Backside 
            Air. // Stalefish : la main arrière grabbe la carre backside entre les talons. // Tail grab : La main 
            arrière grabbe le tail .)",
            'video' => ['https://www.youtube.com/embed/L4bIunv8fHM?list=PLGERIDbPqtLvyPUHaqnLSkizFoQnvpTeN'],
            'picture' => ['gb1.jpeg', 'gb2.jpeg', 'gb3.jpg']
        ],
        [
            'group' => 2,
            'name' => 'Tail bonk',
            'description' => "L’idéal dans ce genre de tricks est d’avoir un spot avec un peu de distance entre le kick 
            et l’objet (poubelle, poteau, muret, jalon...) que tu veux « bonker ». Ensuite il faut arriver le plus à 
            plat possible, genoux fléchis, en visualisant bien l’endroit où tu vas venir taper ta deck afin d’avoir le 
            bon axe en sortie de kick. On déclenche le ollie en pompant au mieux dans le kicker afin de profiter de la 
            relance de la planche. La clé de ce trick, c’est d’arriver à lancer une rotation backside tout en 
            restant durant un laps de temps dans une démarche de shity front. C’est-à-dire que les épaules vont partir 
            dans un sens alors que les jambes vont, elles, entamer une démarche de rotation opposée . Le moment
             crucial du bonk arrive et c’est grâce à lui que le corps va complètement partir dans la direction des 
             épaules et relancer les jambes dans l’autre sens . Le regard va ensuite venir chercher le 
             landing, on contracte les abdos et le reste du corps suivra (reste de la séquence). Une petite variante en 
             faisant d’abord un simple 180 en sortie permettra de se familiariser avec le trick avant d’y aller plus 
             franchement pour le 360.",
            'video' => null,
            'picture' => ['tb1.jpg', 'tb2.jpg', 'tb3.jpg']
        ],
        [
            'group' => 0,
            'name' => 'Fifty Fifty 270',
            'description' => "Comme sur beaucoup de spots en street, un élastique a servi à cette séquence. Une fois 
            le palonnier entre les mains, les potes lâchent tout, et c'est parti. Bien penser à visualiser en amont la 
            prise d'élan et l'entrée du spot (car on arrive vite dessus), afin de se positionner au mieux et aborder 
            l'entrée de la manière la plus stable possible. Effectuer un ollie, bien positionner le poids du corps à 
            l'aplomb du rail et maintenir ses épaules parallèles à la board afin d'effectuer le 50-50. Laisser slider 
            quelques mètres et commencer à préparer le ollie de sortie tout en décalant son corps vers la réception.Un 
            léger coup de pop sur la pointe des pieds en tournant le haut du corps et les épaules en front pour lancer 
            le 360. Dans la rotation, essayer de placer le regard le plus tôt possible dans la réception afin d'assurer 
            une bonne replaque… EASY quoi !!!",
            'video' => null,
            'picture' => ['ff1.jpg', 'ff2.jpg', 'ff3.jpg']
        ],
        [
            'group' => 2,
            'name' => 'Backside 180',
            'description' => "Le Backside 180 peut s’expliquer en plusieurs phases. Tout d'abort la phase d’approche 
            consiste à avoir sa planche la plus à plat possible ou légèrement sur la carre frontside, le regard est 
            pointé vers le spot (l’endroit où on veut décoller). Les jambes sont fléchies, prêtes à donner une 
            impulsion. Pour l’impulsion on a le choix entre un ollie façon skate (comme on peut le voir dans notre tuto 
            sur le Ollie) et une impulsion franche à deux pieds. 
            L’impulsion à deux pieds conviendra mieux sur un kicker de park alors qu’un ollie plus skate et un peu sur 
            la carre est plus évident en bord de piste. Donc on envoie une impulsion  en enclenchant très doucement 
            les épaules de 30°.Ensi=uite il faut engager la rotation à l’aveugle, de dos… pas de panique, l’astuce 
            est de regarder votre pied arrière pour voir défiler le sol en dessous et permettre au corps de faire un 
            180° progressif. Attendez de voir la réception pour ajuster la board  tout en gardant les épaules dans 
            l’axe de la planche ou légèrement en retard pour bien arrêter la rotation. Enfin la réception : bien amortir
             sur les jambes, continuer de regarder entre les pieds pour garder l’équilibre. Ce n’est qu’une fois que 
             l'on a bien amorti qu'on pourra relever la tête et regarder ou l'on va…",
            'video' => ['https://www.youtube.com/embed/Sj7CJH9YvAo'],
            'picture' => ['bs1.jpg', 'bs2.jpg', 'bs3.jpg']
        ],
        [
            'group' => 2,
            'name' => 'Shred',
            'description' => "Ce qui est bien c’est qu’avec le shred,  c'est qu'on n'a pas besoin de prendre trop de 
            vitesse pour exécuter un trick, ça rend toujours une piste banale beaucoup plus fun sans prendre 
            trop de risques. Pour commencer et vraiment progresser en shred,  le mieux est de rider une petite board 
            bien souple qui va se plier facilement et va permettre  d’apprendre et de progresser sur des tricks plus 
            facilement avec plus de tolérance, spécialement avec les boards qui sont bien souples en torsion. Si on 
            est à l’aise et que l’on sait bien plier sa board, on peut aussi faire tout ça avec une board plus ferme 
            et performante, ça sera toujours plus polyvalent... Pour commencer il faut apprendre à marcher avec sa 
            board, de face en rebondissant d’une spatule sur l’autre. Ça entraine à bien manier sa board, à être plus 
            à l’aise dessus et à mieux la contrôler. Il faut aussi apprendre à bien rider en switch (marche arrière), 
            c’est toujours bien de savoir rider dans les deux sens quand on veut faire du freestyle, et encore plus 
            pour shredder. Le premier tricks de shred que l’on conseille c’est le 180 front. Il suffit de faire un 
            ollie en ouvrant les épaules de face, puis une fois en l’air faire pivoter le bas du corp pour le mettre 
            dans l’axe de la réception et ainsi replaquer en switch. On peut faire ce 180 front sur beaucoup de spots 
            tout comme les autres tricks que l’on a appris dans les tutos précédents : Ollie, 180 back et switch 180 
            back, 3.6 back, 3.6 front et les cab 3.6. Les press sont les appuis sur les spatules, on peut les faire 
            dans l’axe ou en travers, ce sont de bons tricks pour apprendre à bien maitriser sa board et une bonne base 
            pour les tricks de Flat. Les tricks de Flat justement, on conseille de vraiment apprendre où est le point 
            de flexion en press de ses spatules avant de se lancer. Une fois que l’on  maitrise bien ce press, on peut 
            essayer de faire un 180 et de d’atterrir en press, puis de sortir de ce press en poppant (appuyer sur la 
            spatule pour avoir un rebond et décoller comme en ollie) et ainsi faire un autre 180, ou un 360... On verra 
            en détails certains tricks dans des prochain tutos, dans celui-ci le but est vraiment d’apprendre à 
            combiner ce qu’on à appris dans les tutos précédent en y rajoutant quelques notions de press, de carving et 
            de lecture de terrain. N’oublions pas que le snowboard c’est juste pour le fun, il ne faut pas hésiter à 
            aller s'amuser en shreddant ou bon nous semble, sur les pistes autant que dans un jardin ou en ville, tant 
            qu’il y a un bout de neige et de la motivation, ça sera une bonne session.",
            'video' => ['https://www.youtube.com/embed/SFYYzy0UF-8','https://www.youtube.com/embed/WbDaEmmgULA'],
            'picture' => null
        ],
        [
            'group' => 1,
            'name' => 'Vale flip',
            'description' =>" Pour expliquer un peu ce trick, il faudrait déjà lui donner un nom ! C’est un mélange 
            entre un fs 5 underflip et un rodéo 5. En tout cas, c’est clairement un trick inspiré du pipe que j’ai 
            adapté à ce petit bout de quarter fait maison. Je vais essayer de vous donner les différentes étapes mais 
            comme pour beaucoup de tricks, je pense que le plus important c’est d’avoir la rotation en tête et après 
            c’est beaucoup de feeling. En premier il faut déjà prendre le bon speed, bien adapté au spot que vous 
            ridez. Ensuite, pour utiliser tout le potentiel de votre spot, il faut bien attendre la toute fin du 
            kick/courbe pour lancer le trick. On arrive board à plat, on laisse sortir le nose et, à ce moment-là, 
            on pope. Si vous déclenchez trop tôt, vous allez perdre en hauteur et surtout risquer de replaquer sur le 
            coping ! Donc on se laisse bien sortir et une fois en l’air on envoie l’épaule gauche et la tête pour 
            commencer la rotation. Ensuite on vient rapidement grabber avec l’autre main et on reste en boule tout le 
            long pour que la rotation soit fluide. Et enfin, comme pour la plupart des tricks, on vient chercher la 
            réception avec le regard afin d’anticiper. Si vous êtes dans le bon timing tout se passera bien. Le plus 
            simple pour apprendre reste de se lancer, donc je vous conseille d’essayer, vous allez voir c’est pas si 
            dur !",
            'video' => null,
            'picture' => ['vf1.jpg', 'vf2.jpg', 'vf3.jpg', 'vf4.jpg', 'vf5.jpg']
        ],
        [
            'group' => 2,
            'name' => 'Front Blunt 270',
            'description' => "Prendre un peu d'élan en regardant bien l'entrée du curb. Placer son ollie et effectuer 
            un quart de tour en backside. De ce fait, vous vous retrouvez dos au module. Venir mettre son corps 
            au-dessus du tail et de sa jambe arrière afin d'effectuer un front blunt. Après avoir slidé quelques mètres,
             anticiper la sortie en tournant le haut du corps et les épaules dans l'axe de la rotation souhaitée en 
             sortie de trick (ici en backside. Mettre une petite impulsion pour faire le 270 en sortie et aller chercher
              le landing avec le regard. Replaquer avec nonchalance… Souriez. Vous êtes filmé. Si vous voulez 
              «gangsteriser» un peu le trick, vous pouvez combiner la sortie en 2.7 avec un nose bonk.",
            'video' => null,
            'picture' => ['fb1.jpg', 'fb2.jpg', 'fb3.jpeg']
        ],
        [
            'group' => 1,
            'name' => 'Backflip',
            'description' => " Le mieux c’est de s’entrainer à le faire sur un trampoline car le mouvement est le même.
            Choisissez un kicker de bord de piste, qui kicke un peu de préférence, pour vous aider à envoyer facilement
            Arrivez bien fléchi en appui sur les 2 jambes et fixez le bout du kicker. L’impulsion se fait à 2 pieds au 
            bout du kicker et pas avant : si on envoie trop tôt on risque de taper la tête dans le kicker ou de trop 
            tourner, de faire un tour et demi et de tomber sur la tête. Deux situations à éviter... Donc impulsion à 
            deux pieds, et on envoie la tête en arrière pour chercher le mouvement. Dès que l’on a décollé il faut 
            remonter les genoux pour enrouler le mouvement. Les profs de gym ont tendance à dire que l’on envoie le 
            mouvement avec le bassin, ce qui n’est pas faux mais c’est surtout quand on a compris le mouvement et que 
            l’on est à l’aise avec. Donc regrouper les jambes en les montant. A ce moment on peut aussi penser à 
            grabber mais ce n’est pas obligé pour commencer... On continue d’emmener la rotation avec la tête en 
            arrière. Très vite on peut voir la réception et on va pouvoir gérer la fin de al rotation soit en se 
            tendant un peu pour la ralentir, soit en se regroupant encore davantage pour tourner plus vite. Replacez 
            bien la board sous votre corps avant d’atterrir, et amortir en pliant les jambes",
            'video' => ['https://www.youtube.com/embed/SlhGVnFPTDE', 'https://www.youtube.com/embed/W853WVF5AqI'],
            'picture' =>['bf1.jpeg', 'bf2.jpg', 'bf3.jpeg']
        ],

    ];

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Modèle de construction de données utilisateurs en base de donnée
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setLoginName('user'.$i);
            $user->setEmail('user'.$i.'@gmail.com');
            $avatar = new Avatar();
            $avatar->setPath('/assets/image/avatar/base.jpg');
            $user->setAvatar($avatar);
            $user->setPlainPassword('user'.$i);
            $manager->persist($user);
            $users[] = $user;
        }

        foreach ($this->groups as $value) {
            $group = new Group();
            $group->setName($value);
            $manager->persist($group);
            $listGroup[] = $group;
        }

        foreach ($this->tricks as $value) {
            $trick = new Trick();
            $trick->setGroup($listGroup[$value['group']]);
            $trick->setName($value['name']);
            $trick->setDescription($value['description']);

            if ($value['picture']) {
                foreach ($value['picture'] as $file) {
                    $picture = new Picture();
                    $picture->setPath('/assets/image/trick/'.$file);
                    $trick->addPicture($picture);
                }
            }


            if ($value['video']) {
                foreach ($value['video'] as $path) {
                    $video = new Video();
                    $video->setPath($path);
                    $trick->addVideo($video);
                }
            }

            foreach ($users as $user) {
                $chat = new Chat();
                $chat->setUser($user);
                $chat->setMessage('message test');
                $trick->addChat($chat);
            }
            $manager->persist($trick);
        }

        $manager->flush();
    }
}
