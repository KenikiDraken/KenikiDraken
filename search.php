<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deux Carrés avec Boutons</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f0f0;
}

.container {
    display: flex;
}

.square-left {
    width: 200px;
    height: 200px;
    background-color: #3498db;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-right: 20px;
}

.square-right {
    width: 400px;
    height: 200px;
    background-color: #2ecc71;
}

.button {
    padding: 10px 20px;
    margin: 10px 0;
    background-color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.button:hover {
    background-color: #ecf0f1;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="square-left">
            <button class="button">Bouton 1</button>
            <button class="button">Bouton 2</button>
        </div>
        <div class="square-right"></div>
    </div>
</body>
</html>
