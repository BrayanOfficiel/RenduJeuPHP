<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Squid Game - sortirez-vous vivant ?</title>
    <link rel="shortcut icon" href="https://scontent-cdg4-3.xx.fbcdn.net/v/t39.30808-6/245367960_108319951627850_333714821506102651_n.png?_nc_cat=106&ccb=1-7&_nc_sid=5f2048&_nc_ohc=NFriSIxxv3oAX8gFqzp&_nc_ht=scontent-cdg4-3.xx&oh=00_AfDgg1PAwdD_EoLVUHJ5XmABC5OiE5nKqlwo73MSyCxdLQ&oe=655CBE2F" type="image/x-icon">
</head>
<body>
    <h1>Bienvenue dans squid game</h1>
    <form action="game.php" method="post">
        <label for="character">Choisissez votre personnage :</label>
        <select name="character" id="character">
            <option value="Seong Gi-hun">Seong Gi-hun</option>
            <option value="Kang Sae-byeok">Kang Sae-byeok</option>
            <option value="Cho Sang-woo">Cho Sang-woo</option>
        </select>
        <br><br>
        <label for="difficulty">Choisissez la difficulté :</label>
        <select name="difficulty" id="difficulty">
            <option value="Facile">Facile</option>
            <option value="Difficile">Difficile</option>
            <option value="Impossible">Impossible</option>
        </select>
        <br><br>
        <input type="submit" name="startGame" value="Commencer le jeu">
    </form>
</body>
</html>
