<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Squid Game - sortirez-vous vivant ?</title>
    <link rel="shortcut icon"
        href="https://scontent-cdg4-3.xx.fbcdn.net/v/t39.30808-6/245367960_108319951627850_333714821506102651_n.png?_nc_cat=106&ccb=1-7&_nc_sid=5f2048&_nc_ohc=NFriSIxxv3oAX8gFqzp&_nc_ht=scontent-cdg4-3.xx&oh=00_AfDgg1PAwdD_EoLVUHJ5XmABC5OiE5nKqlwo73MSyCxdLQ&oe=655CBE2F"
        type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>

</html>

<?php
session_start();

// Initialisation des personnages et des adversaires
$characters = [
    // personnages 
    'Seong Gi-hun' => ['marbles' => 15, 'loss' => 2, 'gain' => 1, 'scream_war' => 'Victoire !'],
    'Kang Sae-byeok' => ['marbles' => 25, 'loss' => 1, 'gain' => 2, 'scream_war' => 'Gagné !'],
    'Cho Sang-woo' => ['marbles' => 35, 'loss' => 0, 'gain' => 3, 'scream_war' => 'Je suis le meilleur !']
];

// Fonction qui génére les adversaires
function generateOpponents()
{
    // générer 20 adversaires avec un nom allant de adversaire 1 a 20, des billes aléatoires et in âges aléatoires
    $opponents = [];
    for ($i = 1; $i <= 20; $i++) {
        $opponents[] = [
            'name' => "Adversaire $i",
            'marbles' => rand(1, 20),
            'age' => rand(20, 90)
        ];
    }
    return $opponents;
}

function recommencer()
{
    // réinitialiser  la session et rediriger vers index.php
    session_unset();
    session_destroy();
    header('Location: index.php');
}

// d.but
if (isset($_POST['startGame'])) {
    // récupérer les données du formulaire et les stocker dans la session
    $difficultyLevels = ['Facile' => 5, 'Difficile' => 10, 'Impossible' => 20];
    $selectedDifficulty = $_POST['difficulty'];
    $numberOfRounds = $difficultyLevels[$selectedDifficulty];

    $selectedCharacter = $_POST['character'];
    $player = $characters[$selectedCharacter];
    $player['name'] = $selectedCharacter;

    $_SESSION['player'] = $player;
    $_SESSION['opponents'] = generateOpponents();
    $_SESSION['currentRound'] = 1;
    $_SESSION['numberOfRounds'] = $numberOfRounds;
} else {
    header('Location: index.php');
    // pour eviter lees erreurs quand on lance le jeu sans avoir choisi de personnage
}

// pari
if (isset($_POST['guess'])) {
    // récupérer les données de la session
    $player = $_SESSION['player'];
    $currentRound = $_SESSION['currentRound'];
    $opponents = $_SESSION['opponents'];
    $numberOfRounds = $_SESSION['numberOfRounds'];

    $opponent = $opponents[$currentRound - 1];
    $guess = $_POST['guess'];
    if ($opponent['marbles'] % 2 === 0) {
        $actual = 'pair';
    } else {
        $actual = 'impair';
    }

    if ($guess === $actual) {
        $player['marbles'] += $opponent['marbles'] + $player['gain'];
    } else {
        $player['marbles'] -= $opponent['marbles'] - $player['loss'];
    }

    $_SESSION['player'] = $player;
    $_SESSION['currentRound']++;
}

// jeu
if (isset($_SESSION['player']) && isset($_SESSION['currentRound']) && isset($_SESSION['numberOfRounds'])) {
    $player = $_SESSION['player'];
    $currentRound = $_SESSION['currentRound'];
    $opponents = $_SESSION['opponents'];
    $numberOfRounds = $_SESSION['numberOfRounds'];

    if ($currentRound > $numberOfRounds || $player['marbles'] <= 0) {
        // si le jeu est terminé
        if ($player['marbles'] > 0) {
            // si le joueur a gagné
            echo "Tu as a gagné la partie avec {$player['marbles']} billes et tu remporte 45,6 milliards de Won !";
            echo "<a href='reset.php'>Recommencer</a>";
        } else {
            // si le joueur a perdu
            echo "Jeu terminé. Tu as perdu toutes tes billes. ";
            echo "{$opponent['name']} a gagné la partie avec {$opponent['marbles']} billes.";
            echo "<a href='reset.php'>Recommencer</a>";
        }
    } else {
        // si le jeu continue
        $opponent = $opponents[$currentRound - 1];

        echo "<div class='progres'><p>Manche $currentRound: Vous affrontez {$opponent['name']} qui a {$opponent['age']} ans.</p>";
        echo "<p>Il vous reste {$player['marbles']} billes.</p></div>";

        echo "<form action='' method='post'>";
        echo "<input type='submit' name='guess' class='radio parier' value='Pair'>";
        echo "<input type='submit' name='guess' class='radio parier' value='Impair'>";
        echo "<a class='reset' href='reset.php'>Reset</a>";
        echo "</form>";
    }
} else {
    // si le jeu n'a pas encore commencé
    echo "<form action='' method='post'>";
    echo "<select name='character'>";
    foreach ($characters as $name => $character) {
        echo "<option value='$name'>$name</option>";
    }
    echo "</select>";
    echo "<select name='difficulty'>";
    foreach ($difficultyLevels as $level => $rounds) {
        echo "<option value='$level'>$level</option>";
    }
    echo "</select>";
    echo "<input type='submit' name='startGame' value='Commencer le jeu'>";
    echo "<a href='reset.php'>Reset</a>";
    echo "</form>";
}
?>