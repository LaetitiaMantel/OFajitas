<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Brand;
use App\Entity\Review;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ReviewRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{    
    // tableau des catégories 
    private $categories = [];

    // tableau des marques
    private $brands = [];

    private $products = [];

    public function __construct(
        private SluggerInterface $slugger,
        private ReviewRepository $reviewRepository
    ){
    }



    public function load(ObjectManager $manager): void
    {

        // tableau des catégories 
        $categories = [
            [
                'name' => 'Bijoux',
                'homeOrder' => '1',
                'picture' => 'https://i.pinimg.com/736x/0d/dd/54/0ddd547940c67e20da299af168898f51.jpg'
            ],
            [
                'name' => 'Pret à porter',
                'homeOrder' => '2',
                'picture' => 'https://ih1.redbubble.net/image.1911015918.1632/ssrco,slim_fit_t_shirt,mens,101010:01c5ca27c6,front,square_product,600x600.jpg'
            ],
            [
                'name' => 'Jouet',
                'homeOrder' => '3',
                'picture' => 'https://i5.walmartimages.ca/images/Enlarge/583/440/6000202583440.jpg?odnHeight=612&odnWidth=612&odnBg=FFFFFF'
            ],
            [
                'name' => 'Décoration',
                'homeOrder' => '4',
                'picture' => 'https://i.etsystatic.com/8910527/r/il/2b98eb/1127905000/il_570xN.1127905000_2glf.jpg'
            ],
            [
                'name' => 'Divers',
                'homeOrder' => '5',
                'picture' => 'https://i.etsystatic.com/20040893/r/il/1c1a33/5121041702/il_1588xN.5121041702_pern.jpg'
            ],
        ];

        // tableau des marques
        $brands = [
            [
                "name" => "Melissa & Doug"
            ],
            [
                "name" => "puzzleYou"
            ],
            [
                "name" => "Etsy"
            ],
            [
                "name" => "Pixers"
            ],
            [
                "name" => "Temu"
            ],
            [
                "name" => "REDBUBLE"
            ],
        ];

        $products = [
            [
                'name' => 'Tableau imprimable',
                'description' => "Imprimable 'FAJITAS love is spicy' High Resolution File. Trois tailles disponibles en téléchargement: 5x7, 8x10, 11x14. REMARQUE  :Vous achetez un fichier numérique uniquement. Aucun article physique ne sera expédié. Aucun matériel imprimé n'est inclus. Vous pouvez imprimer à partir de votre ordinateur personnel ou envoyer à un imprimerie.",
                'picture' => 'https://i.etsystatic.com/8910527/r/il/2b98eb/1127905000/il_1588xN.1127905000_2glf.jpg',
                'price' => '299',
                'status' => true,
                'brand' => '3',
                'category' => '3'
            ],

            [
                'name' => 'Enseigne au néon',
                'description' => 'L’enseigne néon offre une grande polyvalence en termes d’emplacement d’installation, car elle peut être utilisée aussi bien en intérieur qu’en extérieur à l’abri du soleil direct et de la pluie. Dans un environnement intérieur, tel qu’un magasin, un restaurant, un bar ou un bureau, une enseigne néon peut être placée sur un mur, au-dessus d’une porte, derrière un comptoir ou même suspendue au plafond. ',
                'picture' => 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQR8kPbyL1yNac_VEBN1DNUnNnq27K52_BElvc8Q-ZxYSqEKdHa',
                'price' => '3599',
                'status' => true,
                'brand' => '5',
                'category' => '3'
            ],

            [
                'name' => 'Tshirt eater Fajitas',
                'description' => "Un basique pour tous les jours, à assortir les yeux fermés. Coupe carrée classique et confortable.",
                'picture' => 'https://ih1.redbubble.net/image.2335228490.5166/ssrco,classic_tee,womens,101010:01c5ca27c6,front_alt,square_product,600x600.jpg',
                'price' => '1699',
                'status' => true,
                'brand' => '5',
                'category' => '1'
            ],

            [
                'name' => 'Tshirt cool fajitas',
                'description' => "Comme le t-shirt classique, mais en légèrement plus près du corps. Coupe ajustée. Si vous préférez une coupe moins près du corps, commandez une taille au-dessus ou jetez un coup d'œil au t-shirt classique.",
                'picture' => 'https://ih1.redbubble.net/image.2180981763.3697/ssrco,slim_fit_t_shirt,mens,101010:01c5ca27c6,front,square_product,600x600.jpg',
                'price' => '2199',
                'status' => true,
                'brand' => '5',
                'category' => '1'
            ],

            [
                'name' => 'Rouleau de papier peint',
                'description' => "Le papier peint en rouleau que nous proposons en rouleaux se caractérisent par une incroyable profondeur de couleur, grâce à l'utilisation d'une technologie innovante qui reproduit fidèlement l'intensité des couleurs. La laine polaire est un matériau très solide, résistant au rétrécissement et à l'étirement. Par conséquent, il n'y a pas d'espace inesthétique entre les brites après l'application du papier peint. Faites confiance à notre expérience en matière de création de tapisserie.",
                'picture' => 'https://img.pixers.pics/download(cms:2017/04/58e7579629bc7_nastolatek320x195-new.png):compose(download(s3:700/FO/16/36/15/88/5/700_FO163615885_16b8a816426344260343944d184687c8.jpg):pattern(0.25w,0.25h):crop(0w,0.241h,1w,0.5186h):resize(1664,863):format(png),dst_over,0,0):compose(download(cms:2017/04/58e244fad3368_bg-jpg.jpeg),dst_over,0,0):resize(800,0):format(jpeg)/rouleaux-de-papier-peint--modele-sans-couture-colore-dessin-anime-mignon-avec-tacos-mexicains-mais-laitue-et-haricots-rouges-beau-modele-de-fastfood-pour-le-papier-d-39-emballage-de-textile-cafe-et-restaurant-couvertures-bannieres-fond-fond-d-39-ecran.jpg.jpeg',
                'price' => '2699',
                'status' => true,
                'brand' => '3',
                'category' => '3'
            ],

            [
                'name' => 'Rouleau de papier peint fajitas',
                'description' => "Chez Pixers, nous proposons du papier peint en rouleau sur un support d'entoilage d'une qualité exceptionnelle. Nos rouleaux de papier peint se caractérisent par la largeur standard du rouleau (0,5 m x 10 m) qui, combinée au matériau semi-mat et au nombre illimité de motifs disponibles, permet une décoration extraordinaire de n'importe quelle pièce.",
                'picture' => 'https://img.pixers.pics/download(cms:2017/04/58e7579629bc7_nastolatek320x195-new.png):compose(download(s3:700/FO/10/37/68/69/7/700_FO103768697_d0e983068fc014f2763cf9e516cd3c1b.jpg):pattern(0.25w,0.25h):crop(0w,0.241h,1w,0.5186h):resize(1664,863):format(png),dst_over,0,0):compose(download(cms:2017/04/58e244fad3368_bg-jpg.jpeg),dst_over,0,0):resize(800,0):format(jpeg)/rouleaux-de-papier-peint--modele-sans-couture-avec-taco-mexicain-dans-la-tortilla-de-ble.jpg.jpeg',
                'price' => '2699',
                'status' => true,
                'brand' => '3',
                'category' => '3'
            ],

            [
                'name' => 'Tablier Fajitas',
                'description' => "Pour cuisiner, peindre, jardiner ou faire des barbecues sans salir ses vêtements, il y a deux options : ne pas s'habiller ou porter un tablier. C'est à vous de voir. Impression par sublimation.100 % polyester. Tour de cou résistant et liens tour de taille extra longs se nouant sur le devant. Taille unique convenant à la plupart des adultes. Lavable en machine.",
                'picture' => 'https://ih1.redbubble.net/image.3135635077.0409/ur,apron_flatlay_front,square,600x600.u3.jpg',
                'price' => '2499',
                'status' => true,
                'brand' => '5',
                'category' => '4'
            ],

            [
                'name' => '50pcs, Autocollants Fajitas',
                'description' => " Pour Bouteilles, Bagages, Ordinateur Portable, Planche À Roulettes, Cahiers, Voitures, Motos, Vélos, Décor De Fête D'anniversaire À Thème Mexicain, Let's Fiesta",
                'picture' => 'https://img.kwcdn.com/product/Fancyalgo/VirtualModelMatting/b6fbd4a0ac3b4fecdc1efb3a0226927b.jpg?imageView2/2/w/800/q/70/format/webp',
                'price' => '179',
                'status' => true,
                'brand' => '4',
                'category' => '4'
            ],

            [
                'name' => 'Couverture Ronde En Flanelle À Imprimé Wrap',
                'description' => "Couverture Douce Et Chaude Pour La Sieste Pour Canapé, Bureau, Lit, Camping, Voyage, Couverture Cadeau Polyvalente Pour Toutes Les Saisons",
                'picture' => 'https://img.kwcdn.com/product/Fancyalgo/VirtualModelMatting/d4505153a77bf59b4eaf73ae5f9bde2f.jpg?imageView2/2/w/800/q/70/format/webp',
                'price' => '999',
                'status' => true,
                'brand' => '4',
                'category' => '4'
            ],

            [
                'name' => 'Couverture Polaire 150x150cm - Fajitas de Noël',
                'description' => "Cette couverture est faite de tissu de flanelle de haute qualité, avec des couleurs vives et un toucher super doux. Elle vous rend chaud et confortable, avec de bons points, des détails de surjet exquis et pas de chaleur étouffante. Elle est très appropriée pour une utilisation dans chambres climatisées. La housse n'exerce aucune pression sur le corps, est durable et peut être pliée de manière compacte. Super doux et se sent bien. ",
                'picture' => 'https://www.cdiscount.com/pdt2/1/7/2/1/700x700/auc7898833637172/rw/plaid-couverture-polaire-150x150cm-tacos-de-noel.jpg',
                'price' => '3599',
                'status' => true,
                'brand' => '4',
                'category' => '4'
            ],

            [
                'name' => 'Joli chouchou Fajitas',
                'description' => "Ce joli chouchou Fajitas est l'accessoire capillaire parfait pour tous ceux qui aiment les Fajitas et la cuisine mexicaine. Que vous soyez accro aux Fajitas ou à la recherche d'un cadeau unique, cet élastique à cheveux rigolo a un joli design Fajitas qui ajoutera une touche ludique à votre look",
                'picture' => 'https://i.etsystatic.com/20490003/r/il/43bca4/5627701554/il_1588xN.5627701554_pne8.jpg',
                'price' => '699',
                'status' => true,
                'brand' => '2',
                'category' => '4'
            ],

            [
                'name' => 'Chaussettes personnalisées',
                'description' => "Vous aimez les fajitas ? Vous avez quelqu’un qui est accro aux fajitas? Donnez-leur une paire confortable de chaussettes fajitas afin qu’ils puissent montrer leur amour fajitas!",
                'picture' => 'https://i.etsystatic.com/26649642/r/il/b7d1b4/2838735730/il_1588xN.2838735730_oqaj.jpg',
                'price' => '2399',
                'status' => true,
                'brand' => '2',
                'category' => '1'
            ],

            [
                'name' => 'Robe pour petite fille',
                'description' => " Les visages sur cette robe la rendent tellement adorable !!! Tous les amateurs de fajitas rêvent ! Fabriquée à partir de soie de lait qui est 95 % coton et 5 % élasthanne, cette robe est non seulement ultra confortable, mais elle est également infroissable !",
                'picture' => 'https://i.etsystatic.com/18799978/r/il/0eeb1c/1776134231/il_1588xN.1776134231_gofm.jpg',
                'price' => '1799',
                'status' => true,
                'brand' => '2',
                'category' => '1'
            ],

            [
                'name' => 'Sac bandoulière forme de Fajitas',
                'description' => "9' X 6' X 2,5. Expédition gratuite le jour même.Expédié depuis Los Angeles. En stock.",
                'picture' => 'https://i.etsystatic.com/32237447/r/il/6f6a34/3661503288/il_1588xN.3661503288_fd9p.jpg',
                'price' => '3499',
                'status' => true,
                'brand' => '2',
                'category' => '1'
            ],

            [
                'name' => 'Lot de 2 pyjamas Fajitas pour bébés',
                'description' => "Confort. Doux. Extensible. Notre tissu innovant Comfy Stretch s'étire pour grandir avec votre enfant, pour rester plus confortable et en forme plus longtemps. Nous avons fait certifier ce produit de manière indépendante avec STANDARD 100 by OEKO-TEX® afin que vous n'ayez pas à vous soucier des substances nocives présentes dans les vêtements de votre bébé.",
                'picture' => 'https://www.gerberchildrenswear.com/cdn/shop/products/zxbcvwt9mgelgsydesoz.jpg?v=1644549529&width=1080',
                'price' => '2299',
                'status' => true,
                'brand' => '2',
                'category' => '1'
            ],

            [
                'name' => "Boucles d'oreilles Fajitas",
                'description' => "Article fait main. Envoyé par une petite entreprise basée ici : France. Matériaux : Inox. Emplacement: Lobe. Fermeture: Crochet d'oreille. Longueur du pendant: 1.5 Pouces; Longueur: 0.8 Pouces. Réalisé sur commande",
                'picture' => 'https://i.etsystatic.com/7637793/r/il/9c2cea/3087527314/il_1588xN.3087527314_btj0.jpg',
                'price' => '2499',
                'status' => true,
                'brand' => '2',
                'category' => '0'
            ],

            [
                'name' => 'Collier fajitas',
                'description' => "Le collier est de couleur or. Le pendentif mesure 0,5 pouce de longueur et 0,75 pouce de largeur",
                'picture' => 'https://i.etsystatic.com/12273715/r/il/5f542b/3768812125/il_1588xN.3768812125_89gu.jpg',
                'price' => '699',
                'status' => true,
                'brand' => '2',
                'category' => '0'
            ],

            [
                'name' => 'Lots de 2 bagues Fajitas',
                'description' => "C’est l’heure des fajitas, et ce délicieux anneau de fajitas est parfait pour les amateurs de fajitas et les fanatiques de restauration rapide. La coquille de tacos dure ou molle est remplie de bœuf haché épicé, de crème sure, de laitue croustillante, de tomates juteuses et de cheddar pointu - tout comme la vraie chose!",
                'picture' => 'https://i.etsystatic.com/5658928/r/il/923b0e/2771600390/il_1588xN.2771600390_aq7z.jpg',
                'price' => '2499',
                'status' => true,
                'brand' => '2',
                'category' => '0'
            ],

            [
                'name' => 'Porte clés fajitas',
                'description' => "Porte-clés Taco fait à la main à partir d'argile polymère, sans utiliser de moule. Il s'agit d'un excellent cadeau d'amitié, de meilleur ami, de sœur, de mère et de fille, de femme et de mari. Taille de la breloque : 2,7 x 1,7 cmLongueur du porte-clés : 6,5 cm",
                'picture' => 'https://i.etsystatic.com/18125298/r/il/6e182a/2309675829/il_1588xN.2309675829_5pt6.jpg',
                'price' => '1250',
                'status' => true,
                'brand' => '2',
                'category' => '4'
            ],

            [
                'name' => "Boucles d'oreille fajitas",
                'description' => "Boucles d'oreilles fajitas smiley émaillées avec fermeture à crochet en or hypoallergénique, Article fait main. Longueur du pendant: 1.4 Centimètres",
                'picture' => 'https://i.etsystatic.com/35012761/r/il/e4cb29/5463799965/il_1588xN.5463799965_2nm8.jpg',
                'price' => '799',
                'status' => true,
                'brand' => '2',
                'category' => '0'
            ],

            [
                'name' => 'Collier fajitas',
                'description' => "Bijoux culinaires, Pendentif tacos, Collier tacos, Breloque tacos, Bijoux culinaires miniatures, Bijoux tacos, Mini tacos alimentaires en pâte polymère alimentaire, Kawaii",
                'picture' => 'https://i.etsystatic.com/6685126/r/il/5fb585/1362909515/il_1588xN.1362909515_jz2l.jpg',
                'price' => '1999',
                'status' => true,
                'brand' => '2',
                'category' => '0'
            ],

            [
                'name' => 'Play-Doh Kitchen Creations - Fajitas',
                'description' => "C'EST L'HEURE DES TACOS - Cet ensemble de nourriture ludique est livré avec tous les outils et composés dont votre petit chef a besoin pour commencer à fabriquer ses propres fajitas !",
                'picture' => 'https://www.lenuagedecharlotte.com/58737-large_default/has-e7447-play-doh-kitchen-creations-tacos.jpg',
                'price' => '1090',
                'status' => true,
                'brand' => '0',
                'category' => '2'
            ],

            [
                'name' => 'Dinette fajitas en bois',
                'description' => "Un set pour déguster les fajitas! Dans cette jolie boîte en bois aux saveurs méditerranéennes, l'enfant prépare des pitas à l'aide d'un menu. Il n'y a plus qu'à déguster !",
                'picture' => 'https://materieleducatifenbois.fr/cdn/shop/products/DJ05500-C-RVB.jpg?v=1649426254&width=3000',
                'price' => '1499',
                'status' => true,
                'brand' => '0',
                'category' => '2'
            ],

            [
                'name' => 'Jouet en peluche pour chien',
                'description' => "La peluche pour chien en forme de Fajitas couine légèrement pour stimuler votre chien pendant le jeu. Elle se sépare en 3 jouets distincts pour encore plus de fun. Le papier sonore à l'intérieur stimulera votre chien pour des heures et des heures.",
                'picture' => 'https://inooko.com/cdn/shop/products/petplay-peluche-ecofriendly-pour-chien-tacos-1_2048x2048.jpg?v=1572369389',
                'price' => '1399',
                'status' => true,
                'brand' => '0',
                'category' => '2'
            ],

            [
                'name' => 'Puzzle « Fajitas de bœuf fraîchement préparés »',
                'description' => "Puzzle de qualité puzzleYOU avec l'image du puzzle comme modèle. Dimensions du puzzle de 1000 pièces : 64 x 48 cm. Carton premium de 2,25 mm, découpage de précision & impression de haute qualité pour un maximum de plaisir. Motif de puzzle de pilipphoto / Shutterstock",
                'picture' => 'https://masa.imagestore.puzzleyou.fr/images/8a7a0c4e-89ac-4d2a-846b-81e51b886b40-965830f056b3d490ea6723d7138fc669?convert=image/jpeg&mipmap=%7B%22width%22%3A%20800%2C%20%22height%22%3A%20600%7D',
                'price' => '2999',
                'status' => true,
                'brand' => '1',
                'category' => '2'
            ],

            [
                'name' => 'Puzzle « Fajitas mexicaines au poulet et au bœuf »',
                'description' => "Chaque pièce a sa propre place, tout comme chaque souvenir a sa propre histoire. Vous devez le mettre dans un endroit exclusif, l'image sera enrichie lorsque vous la mettrez correctement. Exercez la patience, la concentration, la persévérance, l'observation et l'intelligence des gens. Chaque fois que vous terminez un travail, vous ressentez un sentiment d’accomplissement. Vous sentirez qu'un puzzle aussi difficile peut être complété, tout peut être fait avec concentration. Il y a des indices de divisions alphabétiques au dos des puzzles.",
                'picture' => 'https://masa.imagestore.puzzleyou.fr/images/ebaad922-e3b1-4ceb-b31d-ca1dc19327e5-f5ab6cf62cc1676de8ad4e31695d6406?convert=image/jpeg&mipmap=%7B%22width%22%3A%20800%2C%20%22height%22%3A%20600%7D',
                'price' => '2999',
                'status' => 'true',
                'brand' => '1',
                'category' => '2'
            ],

            [
                'name' => 'Ensemble de tacos et tortillas à remplir et plier',
                'description' => "Créez des tacos, des burritos, des fajitas et bien plus encore ! Choisissez des ingrédients alimentaires ludiques, faites semblant de griller des ingrédients en bois tranchés dans la poêle, remplissez une tortilla en feutre ou une coquille à tacos dure et durable, et servez avec un choix de garnitures ludiques ! L'ensemble de 43 pièces comprend trois cartes de menu et de recettes double face réutilisables, ainsi qu'un couteau et une cuillère en bois.",
                'picture' => 'https://www.melissaanddoug.com/cdn/shop/files/68f1cd61e715b357e509d9d928a37239a662400b.jpg?v=1700170085&width=670',
                'price' => '3999',
                'status' => true,
                'brand' => '0',
                'category' => '2'
            ],

            [
                'name' => 'Taco Truck Faire semblant de jouer à imprimer',
                'description' => "Un camion Taco fait semblant de jouer à des imprimables pour les enfants. Comprend 12 pages imprimables.",
                'picture' => 'https://i.etsystatic.com/15161228/r/il/df9872/3963183612/il_1588xN.3963183612_iwhz.jpg',
                'price' => '399',
                'status' => true,
                'brand' => '2',
                'category' => '2'
            ],
        ];


        // super admin
        $user = new User();
        $user->setEmail('supadmin@supadmin.com');
        $user->setRoles(['ROLE_SUPERADMIN']);
        $user->setPassword('$2y$13$RLlU5yiOWZ.UrX2JLGsuzOYqQ1q2b8bnHC6fWNdmbDqU9vpN/GhYO');
        $user->setFirstname('Jonathan');
        $user->setLastname('Fajitas');
        $user->setIsBanned(false);
        $manager->persist($user);

        // admin
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2y$13$nLf0MAlwK3oQBNVeZJaXduk2O5CzhldPfG/9lDNCNgD5pHTaiIyOS');
        $user->setFirstname('Laet');
        $user->setLastname('Fajitas');
        $user->setIsBanned(false);
        $manager->persist($user);

        // manager
        $user = new User();
        $user->setEmail('manager@manager.com');
        $user->setRoles(['ROLE_MANAGER']);
        $user->setPassword('$2y$13$xw9rC.dF9jJmAXnPzTsny.PMghC.NEFlroHkXM92zCQox9SPqokMy');
        $user->setFirstname('Anna');
        $user->setLastname('Fajitas');
        $user->setIsBanned(false);
        $manager->persist($user);

        // user
        $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('$2y$13$/hHmOqI0nPYqOczmSlqGiOEHMh8GPs5H8F5aUUGiDtDHu9JMdudey');
        $user->setFirstname('Franck');
        $user->setLastname('Fajitas');
        $user->setIsBanned(false);
        $manager->persist($user);

        $manager->flush();

        $faker = Factory::create('fr_FR');

        // création des marques
        foreach ($brands as $brand) {
            $newBrand = new Brand;
            $newBrand->setName($brand['name']);
            $newBrand->setSlug($this->slugger->slug($newBrand->getName())->lower());
            $newBrand->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $newBrand->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $manager->persist($newBrand);
            $brandsInDb [] = $newBrand;
        }
        
        $manager->flush();

        //création des catégories
        foreach ($categories as $category) {
            $newCategory = new Category;
            $newCategory->setName($category['name']);
            $newCategory->setHomeOrder($category['homeOrder']);
            $newCategory->setSlug($this->slugger->slug($newCategory->getName())->lower());
            $newCategory->setPicture($category['picture']);
            $newCategory->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $newCategory->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $manager->persist($newCategory);
            $categoriesInDb [] = $newCategory;
        }

        $manager->flush();

        //création des produits
        foreach ($products as $product) {
            $newProduct = new Product();
            $newProduct->setName($product['name']);
            $newProduct->setDescription($product['description']);
            $newProduct->setPicture($product['picture']);
            $newProduct->setPrice($product['price']);
            $newProduct->setRating(null);
            $newProduct->setStatus($product['status']);
            $newProduct->setSlug($this->slugger->slug($newProduct->getName())->lower());
            $newProduct->setCategory($categoriesInDb[$product['category']]);
            $newProduct->setBrand($brandsInDb[$product['brand']]);
            $newProduct->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $newProduct->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
        
            for ($i = 0; $i < random_int(0,6); $i ++){
                $review = new Review;
                $review->setProduct($newProduct);
                $review->setUsername($faker->name());
                $review->setEmail($faker->email());
                $review->setContent($faker->realTextBetween());
                $review->setRating(random_int(1, 5));
                $manager->persist($review);
            }
            $manager->persist($newProduct);
            $manager->flush();
            $averageRating = $this->reviewRepository->averageRating($newProduct);
            $newProduct->setRating($averageRating);
            
        }


        $manager->flush();
    }
}
