## La programmation orientée objet

Le paradigme de **programmation procédurale** met en relation des données (représentées par des **variables**) avec des comportements (représentés par des fonctions). Cette approche présente un certain nombre d'inconvénients, notamment en ce qui concerne l'indépendance du code et sa maintenabilité. La **programmation orientée objet** (POO) tente de pallier ces défauts en proposant de rassembler les données et les comportements qui les traitent au même endroit.

Considérez l'exemple ci-dessous, dans lequel on cherche à savoir quelle carte l'emporte dans un jeu de plis.

<details> 
<summary>Programmation procédurale</summary>

```php
// Permet de déterminer si la carte 1 bat la carte 2
// Renvoie vrai si la carte 1 est plus forte que la 2, faux si la carte 1 est moins forte ou égale à la carte 2
function cardBeats(int $card1Value, int $card2Value) {
    return $card1Value > $card2value;
}

// La première carte est un 3 de coeur
$card1 = ['value' => 3, 'color' => 'hearts'];
// La deuxième carte est un 7 de pique
$card2 = ['value' => 7, 'color' => 'spades'];

cardBeats($card1['value'], $card2['value']);    // => false
cardBeats($card2['value'], $card1['value']);    // => true
```
</details>

<details> 
<summary>Programmation orientée objet</summary>

```php
// Représente une carte
class Card
{
    // Valeur de la carte
    public int $value;
    // Couleur de la carte
    public string $color;

    // Permet de créer une nouvelle carte en précisant sa valeur et sa couleur
    public function __construct(int $value, string $color)
    {
        $this->value = $value;
        $this->color = $color;
    }

    // Permet de déterminer si cette carte bat l'autre carte passée en paramètre
    // Renvoie vrai si cette carte est plus forte que l'autre, faux si cette carte est moins forte ou égale à l'autre
    public function beats(Card $otherCard): bool
    {
        return $this->value > $otherCard->value;
    }
}

// La première carte est un 3 de coeur
$card1 = new Card(3, 'hearts');
// La deuxième carte est un 7 de pique
$card2 = new Card(7, 'spades');

$card1->beats($card2);    // => false
$card2->beats($card1);    // => true
```
</details>

Le code en version POO, bien qu'en apparence plus complexe, simplifie la manipulation des données, car les donneés (les valeurs des cartes) sont couplées avec les méthodes (savoir si une carte est plus forte qu'une autre). On a en quelque sorte "appris" à chaque carte comment se comporter sur la base de sa propre valeur. Dès lors, tout processus qui a accès à la valeur de la carte a, de fait, également accès aux comportements associés.

En outre, le fait d'avoir créé une classe **Card** permet de valider la structure des objets générés à partir de cette classe. Ainsi, dans la méthode **beats**, on peut passer comme paramètre un objet **Card** directement, au lieu de passer uniquement sa valeur. Cela permet de s'assurer que l'objet auquel on cherche à comparer une carte est bien, lui aussi, une carte; alors que dans la version procédurale, on se contente de donner des nombres, il est donc plus difficile de tracer l'origine de ces nombres.

## Héritage et polymorphisme

Une classe définit une structure de données et des comportements associés, correspondant à une entité logique d'une application. _A priori_, chaque classe est différente et incompatible avec les autres classes. Cependant, la plupart des langages orientés objet mettent à notre disposition un mécanisme, appelé **héritage**, qui permet de réutiliser du code de certaines classes dans d'autres classes.

Par exemple, considérez ce code qui définit plusieurs types de produits disponibles dans une boutique en ligne:

<details> 
<summary>Sans héritage</summary>

```php
// Représente un ordinateur
class Computer
{
    // Référence du produit
    public string $reference;
    // Nom du produit
    public string $name;
    // Prix du produit
    public float $price;
    // Modèle du processeur
    public string $processor;
    // Quantité de mémoire vive
    public int $ram;
    // Modèle de la carte graphique
    public string $graphicCard;

    // Permet de créer un nouvel ordinateur
    public function __construct(string $reference, string $name, float $price, string $processor, int $ram, string $graphicCard) {
        $this->reference = $reference;
        $this->name = $name;
        $this->price = $price;
        $this->processor = $processor;
        $this->ram = $ram;
        $this->graphicCard = $graphicCard;
    }

    // Génère une description du produit
    public function getDescription(): string
    {
        return
            'Référence: ' . $this->reference . PHP_EOL .
            'Nom: ' . $this->name . PHP_EOL .
            'Prix: ' . $this->price . ' &euro;' . PHP_EOL .
            'Processeur: ' . $this->processor . PHP_EOL .
            'Mémoire vive: ' . $this->ram . PHP_EOL .
            'Carte graphique: ' . $this->graphicCard . PHP_EOL
        ;
    }
}

// Représente une télévision
class TvScreen
{
    // Référence du produit
    public string $reference;
    // Nom du produit
    public string $name;
    // Prix du produit
    public float $price;
    // Largeur de l'écran
    public int $width;
    // Hauteur de l'écran
    public int $height;

    // Permet de créer une nouvelle télévision
    public function __construct(string $reference, string $name, float $price, int $width, int $height) {
        $this->reference = $reference;
        $this->name = $name;
        $this->price = $price;
        $this->width = $width;
        $this->height = $height;
    }

    // Génère une description du produit
    public function getDescription(): string
    {
        return
            'Référence: ' . $this->reference . PHP_EOL .
            'Nom: ' . $this->name . PHP_EOL .
            'Prix: ' . $this->price . ' &euro;' . PHP_EOL .
            'Largeur: ' . $this->width . PHP_EOL .
            'Hauteur: ' . $this->height . PHP_EOL
        ;
    }
}

// Représente une machine à laver
class WashingMachine
{
    // Référence du produit
    public string $reference;
    // Nom du produit
    public string $name;
    // Prix du produit
    public float $price;
    // Nombre de tours
    public int $spinCycle;
    // Capacité de chargement
    public int $loadCapacity;

    // Permet de créer une nouvelle machine à laver
    public function __construct(string $reference, string $name, float $price, int $spinCycle, int $loadCapacity) {
        $this->reference = $reference;
        $this->name = $name;
        $this->price = $price;
        $this->spinCycle = $spinCycle;
        $this->loadCapacity = $loadCapacity;
    }

    // Génère une description du produit
    public function getDescription(): string
    {
        return
            'Référence: ' . $this->reference . PHP_EOL .
            'Nom: ' . $this->name . PHP_EOL .
            'Prix: ' . $this->price . ' &euro;' . PHP_EOL .
            'Nombre de tours: ' . $this->spinCycle . PHP_EOL .
            'Capacité: ' . $this->loadCapacity . PHP_EOL
        ;
    }
}
```

</details>

On remarque d'emblée des similitudes dans le code de ces trois classes, qui mériteraient d'être factorisées. Par exemple, tous les types de produit ont une référence, un nom et un prix. Mais en même temps, chaque classe a aussi ses spécificités. L'**héritage** nous permet de concilier ces deux aspects en écrivant une nouvelle classe **Product** que l'on qualifiera de **classe-mère** ou de **superclasse**. L'idée est que les type particuliers de produits **héritent** des propriétés communes à tous les types de produits.

<details> 
<summary>Avec héritage</summary>

```php
// Représente un produit en général
class Product
{
    // Référence du produit
    public string $reference;
    // Nom du produit
    public string $name;
    // Prix du produit
    public float $price;

    // Permet de créer un nouveau produit
    public function __construct(string $reference, string $name, float $price) {
        $this->reference = $reference;
        $this->name = $name;
        $this->price = $price;
    }

    // Génère une description du produit
    public function getDescription(): string
    {
        return
            'Référence: ' . $this->reference . PHP_EOL .
            'Nom: ' . $this->name . PHP_EOL .
            'Prix: ' . $this->price . ' &euro;' . PHP_EOL
        ;
    }
}

// Représente un ordinateur
class Computer extends Product
{
    // Modèle du processeur
    public string $processor;
    // Quantité de mémoire vive
    public int $ram;
    // Modèle de la carte graphique
    public string $graphicCard;

    // Permet de créer un nouvel ordinateur
    public function __construct(string $reference, string $name, float $price, string $processor, int $ram, string $graphicCard) {
        // Appelle le contructeur du parent
        parent::__construct(string $reference, string $name, float $price);
        $this->processor = $processor;
        $this->ram = $ram;
        $this->graphicCard = $graphicCard;
    }

    // Génère une description du produit
    public function getDescription(): string
    {
        // Demande au parent de générer une description avant de la compléter
        return
            parent::__getDescription() .
            'Processeur: ' . $this->processor . PHP_EOL .
            'Mémoire vive: ' . $this->ram . PHP_EOL .
            'Carte graphique: ' . $this->graphicCard . PHP_EOL
        ;
    }
}

// Représente une télévision
class TvScreen extends Product
{
    // Largeur de l'écran
    public int $width;
    // Hauteur de l'écran
    public int $height;

    // Permet de créer une nouvelle télévision
    public function __construct(string $reference, string $name, float $price, int $width, int $height) {
        // Appelle le contructeur du parent
        parent::__construct(string $reference, string $name, float $price);
        $this->width = $width;
        $this->height = $height;
    }

    // Génère une description du produit
    public function getDescription(): string
    {
        // Demande au parent de générer une description avant de la compléter
        return
            parent::__getDescription() .
            'Largeur: ' . $this->width . PHP_EOL .
            'Hauteur: ' . $this->height . PHP_EOL
        ;
    }
}

// Représente une machine à laver
class WashingMachine extends Product
{
    // Nombre de tours
    public int $spinCycle;
    // Capacité de chargement
    public int $loadCapacity;

    // Permet de créer une nouvelle machine à laver
    public function __construct(string $reference, string $name, float $price, int $spinCycle, int $loadCapacity) {
        // Appelle le contructeur du parent
        parent::__construct(string $reference, string $name, float $price);
        $this->spinCycle = $spinCycle;
        $this->loadCapacity = $loadCapacity;
    }

    // Génère une description du produit
    public function getDescription(): string
    {
        // Demande au parent de générer une description avant de la compléter
        return
            parent::__getDescription() .
            'Nombre de tours: ' . $this->spinCycle . PHP_EOL .
            'Capacité: ' . $this->loadCapacity . PHP_EOL
        ;
    }
}

$hdTvScreen = new TvScreen('19841964', 'Téléviseur HD', 699.99, 1920, 1080);
$hdTvScreen->reference; // => "19841964"
$hdTvScreen->name;      // => "Téléviseur HD"
$hdTvScreen->price;     // => 699.99
$hdTvScreen->width;     // => 1920
$hdTvScreen->height;    // => 1080

$hdTvScreen->getDescription();    // => "Référence: 19841964\nNom: Téléviseur HD\nPrix: 699.99 &euro;\nLargeur: 1920\nHauteur: 1080\n"

$hdTvScreen instanceof TvScreen;    // => true
$hdTvScreen instanceof Product;     // => true
$hdTvScreen instanceof Computer;    // => false
```

</details> 

On observe que l'objet de classe **TvScreen** a bien hérité des propriétés de **Product**. On peut donc dire que tous les objets **TvScreen** sont **à la fois** des télévisions et des produits.

En outre, il a été possible de **surcharger** la méthode **getDescription**, c'est-à-dire de redéfinir son comportement en incluant le comportement de la classe parente. Une sous-classe ne fait donc pas qu'hériter des comportements, elle peut aussi les transformer si besoin: ceci s'appelle le **polymorphisme**.

L'héritage et le polymorphisme nous donnent donc la flexibilité nécessaire pour factoriser du code commun à plusieurs classes, sans pour autant contraindre le code de chaque sous-classe.

## Classes abstraites

L'exemple précédent qui factorise le code de plusieurs types de produits particuliers dans une seule et même classe **Product** contient un défaut: il est possible d'écrire...

```php
new Product(...);
```

...alors qu'un produit général n'a pas de sens. Nous voulons créer des ordinateurs, des télévisions, etc. et la classe **Product** a uniquement vocation à rassembler le code commun entre les différents types de produits spécifiques. Dans cette situation, on va dire que **Computer**, **TvScreen**, etc. sont des **classes concrètes** (c'est-à-dire qu'elle représentent de véritables objets), alors que **Product** est une **classe abstraite** (c'est-à-dire qu'elle sert de base à des classes concrètes, mais qu'elle ne représente pas de véritables objets en tant que telle).

On écrirait donc le code suivant:

<details> 
<summary>Avec une classe abstraite</summary>

```php
// Représente un produit en général
abstract class Product
{
    ...
}

// Représente un ordinateur
class Computer extends Product
{
    ...
}

// Représente une télévision
class TvScreen extends Product
{
    ...
}

// Représente une machine à laver
class WashingMachine extends Product
{
    ...
}

$product = new Product(...);    // => PHP: Fatal error: Cannot instantiate abstract class
```

</details>

Le mot-clé **abstract** n'ajoute rien au fonctionnement de notre classe **Product**, hormis qu'il interdit de l'instancier. Il s'agit d'une note d'intention qui permet de prévenir d'autres développeurs que cette classe ne sert pas à représenter des objets concrets, mais bien à être dérivée par des sous-classes.

## Interfaces

Comme nous l'avons vu dans la partie précédente, le polymorphisme nous permet d'écrire des sous-classes de manière totalement arbitraire, sans forcément respecter les standards définis par la superclasse. Mais, lorsque l'on écrit du code destiné à être réutilisé par d'autres développeurs, par exemple dans le cadre du développement d'un **framework**, il peut être utile de contraindre la structure du code appelé à être rajouté dans une application. Définir une classe abstraite en est un exemple. Mais on peut aller plus loin en utilisant une **interface**.

Considérez le code suivant, dans lequel on souhaite créer plusieurs genres d'instruments de musique, et que chaque musicien possède un instrument de musique dont il peut jouer.

<details> 
<summary>Sans interface</summary>

```php
// Représente une flûte
class Flute
{
    // Détermine comment souffler dans la flûte
    public function blow(): void
    {
        ...
    }
}

// Représente un violon
class Violin
{
    // Détermine comment frotter les cordes du violon
    public function rub(): void
    {
        ...
    }
}

// Représente une guitare
class Guitar
{
    // Détermine comment pincer les cordes de la guitare
    public function pluck(): void
    {
        ...
    }
}

// Représente un musicien
class Musician
{
    // L'instrument de musique porté par le musicien
    public $instrument;

    // Permet de créer un nouveau musicien
    public function __construct($instrument)
    {
        $this->instrument = $instrument;
    }

    // Détermine comment le musicien doit s'y prendre pour jouer de son intrument
    public function play(): void
    {
        $instrument->???;   // Quel nom de méthode doit-on utiliser ici?
    }
}
```

</details>

Comme chaque instrument a une manière différente de se jouer, le problème que l'on rencontre est qu'il n'est _a priori_ pas possible d'écrire une méthode **play** dans la classe **Musician** capable de s'adapter à toutes les classes d'instruments de musique. On pourrait renommer toutes les méthodes des classes d'instruments de musique en **play** pour qu'elles aient le même nom, mais rien ne nous garantit:

1. que la méthode **play** existe,
2. que la méthode **play** a la bonne signature (autrement dit qu'elle ne prend aucun paramètre et ne doit rien renvoyer),
3. et surtout, que les futures classes d'instrument de musique respecteront ces contraintes.

Une **interface** nous permet de régler ce problème en définissant une structure que les classes présentes et futures doivent obligatoirement respsecter afin d'être acceptées par notre code.

<details> 
<summary>Avec interface</summary>

```php
// Décrit la structure imposée d'un instrument de musique
interface MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void;
}

// Représente une flûte
class Flute implements MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void
    {
        $this->blow();
    }

    // Détermine comment souffler dans la flûte
    public function blow(): void
    {
        ...
    }
}

// Représente un violon
class Violin implements MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void
    {
        $this->rub();
    }

    // Détermine comment frotter les cordes du violon
    public function rub(): void
    {
        ...
    }
}

// Représente une guitare
class Guitar implements MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void
    {
        $this->pluck();
    }

    // Détermine comment pincer les cordes de la guitare
    public function pluck(): void
    {
        ...
    }
}

// Représente un musicien
class Musician
{
    // L'instrument de musique porté par le musicien
    public MusicInstrument $instrument;     // Ici, on détermine que la propriété $instrument doit forcément être un objet conforme à l'intérface MusicInstrument

    // Permet de créer un nouveau musicien
    // Ici, on détermine que l'objet passé au constructeur doit forcément être un objet conforme à l'intérface MusicInstrument
    public function __construct(MusicInstrument $instrument)
    {
        $this->instrument = $instrument;
    }

    // Détermine comment le musicien doit s'y prendre pour jouer de son intrument
    public function play(): void
    {
        $instrument->play();   // Ici, on est certain que $instrument possède une méthode play(), puisqu'il doit obligatoirement être conforme à l'interface MusicInstrument
    }
}
```

</details>

A l'analyse de ce code, on peut s'apercevoir que:

- si on donne à un objet **Musician** un objet d'une classe qui n'implémente pas **MusicInstrument**, cet objet sera refusé en raison du type-hinting. Toutes les classe d'instruments de musiques doivent donc obligatoirement implémenter **MusicInstrument**, sinon elles ne pourront pas interagir avec **Musician**;
- si une classe d'instrument de musique dans laquelle on déclare qu'elle implémente **MusicInstrument** ne contient pas de méthode **play()**, alors on aura un message d'erreur au chargement de cette classe;
- de même, si une classe d'intrument de musique dans laquelle on déclare qu'elle implémente **MusicInstrument** contient une méthode **play()** avec une mauvaise signature (par exemple, on déclare qu'elle prend un nombre en paramètres, qu'elle renvoie une chaîne de caractères, etc.), alors on aura un message d'erreur au chargement de cette classe.

Si le code arrive sans erreur jusqu'à la méthode **play** de **Musician**, nous sommes donc absolument certains que l'instrument de musique:

1. possède une méthode **play()**,
2. que **play()** est la bonne manière de l'appeler,
3. et qu'il est donc impossible d'obtenir une erreur liée à l'appel de la méthode.

Et ce, peu importe la classe réelle de l'objet **$instrument**. Le fait de déclarer une interface nous permet donc d'assurer une compatibilité du code actuel avec le code futur, et évite de laisser penser, en cas d'erreur, que le problème vient de la classe client (dans cet exemple, **Musician**) alors qu'il vient de la façon dont une future classe sera construite (dans ces exemple, un instrument de musique).

## Classes abstraites et interfaces

Il est possible de combiner interfaces et classes abstraites lorsque les circonstances s'y prêtent, mais dans ce cas, elles n'auraient pas le même sens.

Considérez ce code dans lequel on veut définir plusieurs instruments de musique qui ont une manière de se jouer commune:

<details> 
<summary>Avec interface</summary>

```php
// Décrit la structure imposée d'un instrument de musique
interface MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void;
}

// Représente une flûte
class Flute implements MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void
    {
        $this->blow();
    }

    // Détermine comment souffler dans la flûte
    public function blow(): void
    {
        ...
    }
}

// Représente une trompette
class Trumpet implements MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void
    {
        $this->blow();
    }

    // Détermine comment souffler dans la trompette
    public function blow(): void
    {
        ...
    }
}

// Représente un cor anglais
class Horn implements MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void
    {
        $this->blow();
    }

    // Détermine comment souffler dans le cor
    public function blow(): void
    {
        ...
    }
}
```

</details>

Grâce à l'interface **MusicInstrument**, on a la garantie que tous nos instruments de musique doivent définir une manière de se jouer à travers la méthode **play()**. C'est un bon début, mais dans le cas de plusieurs instruments à vent, on se retrouve ici avec du code dupliqué. Et en même temps, même s'il faut dans tous les cas souffler dans un instrument à vent, la manière de jouer d'une flûte n'est pas tout à fait la même que celle de jouer d'une trompette. On aimerait donc pouvoir factoriser la méthode **play()** de tous les instruments à vent, tout en se laissant la liberté de redéfinir la méthode **blow()** dans chaque classe concrète.

On pourrait alors écrire le code suivant:

<details> 
<summary>Avec interface et classe abstraite</summary>

```php
// Décrit la structure imposée d'un instrument de musique
interface MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    public function play(): void;
}

// Représente un instrument à vent en général
abstract class WindInstrument implements MusicInstrument
{
    // Détermine comment on doit jouer de l'instrument
    // Ici, on explique que tous les instruments à vent fonctionnent en soufflant dedans
    public function play(): void    
    {
        $this->blow();
    }

    // Détermine comment souffler dans l'instrument concret
    // Ici, on détermine qu'un instrument à vent doit forcément implémenter une méthode blow() pour que le code de cette classe fonctionne
    abstract function blow(): void;
}

// Représente une flûte
class Flute extends WindInstrument
{
    // Détermine comment souffler dans la flûte
    public function blow(): void
    {
        ...
    }
}

// Représente une trompette
class Trumpet extends WindInstrument
{
    // Détermine comment souffler dans la trompette
    public function blow(): void
    {
        ...
    }
}

// Représente un cor anglais
class Horn extends WindInstrument
{
    // Détermine comment souffler dans le cor
    public function blow(): void
    {
        ...
    }
}
```

</details>

La classe **WindInstrument** agit ici comme un hybride entre une classe et une interface: elle propose une implémentation pour la méthode **play()** que lui impose l'interface **MusicInstrument**, et en même temps elle impose à ses sous-classes de d'implémenter la méthode **blow()** qu'elle appelle. Autrement dit, **WindInstrument** est une classe laissée volontairement **incomplète**, afin de tirer parti du polymorphisme. On retrouve donc le principe d'avoir une classe abstraite nous donnant la flexibilité nécessaire au fait de factoriser du code commun, et en même temps de laisser les sous-classes définir leurs propres comportements. En outre, en raison du mot-clé **abstract**, il ne sera pas possible de créer des instruments à vent génériques, on ne pourra créer que des flûtes, des trompettes, etc.

A noter que ce code reste entièrement compatible avec la classe **Musician** proposé dans la partie précédente, ajouter une classe abstraite implémentant l'interface **MusicInstrument** n'a donc aucune incidence sur la compatibilité du code.

La différence essentielle entre une classe abstraite et une interface est qu'une classe abstraite peut proposer des fonctionnement destinés à être réutilisés, alors qu'une interface est simplement une spécification. Autrement dit, si les règles à respecter dans l'écriture d'un poème (nombre de pieds, rimes, etc.) est une interface, alors une classe abstraite sera un modèle dans lequel une partie du poème sera déjà écrite, et qui laisse la liberté à des classes concrètes d'écrire le reste du poème à leur manière. En outre, il est toujours possible d'écrire un poème complet en se passant du modèle, tant que la consigne reste respectée.

Interfaces et classes abstraites sont donc complémentaires et ne répondent pas au même besoin. L'interface impose une structure afin d'assurer la compatibilité, la classe abstraite donne une base commune pour la création de classes concrètes.

Il est donc assez commun d'avoir des classes structurées en trois couches:

- **les classes concrètes**: Si vous souhaitez utiliser des fonctionnements déjà prévus, vous pouvez utiliser directement nos classes concrètes.
- **les classes abstraites**: Si vous souhaitez créer de nouveaux fonctionnements qui réutilisent des fonctionnements existants, vous pouvez créer vos propres classes concrètes à partir de nos classes abstraites.
- **les interfaces**: Si vous souhaitez créer de nouveaux fonctionnements, mais sans réutiliser aucun des fonctionnements existanst, vous pouvez créer vos propres classes en les rendant compatibles avec nos interfaces.

Une telle structure offre le meilleur compromis entre donner aux autres développeurs du code qu'ils peuvent réutiliser tel quel à un extrême, et à l'autre extrême de tout réécrire à leur façon tout en les assurant que leur code reste compatible avec le nôtre.
