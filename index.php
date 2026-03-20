<?php
$plik = "notes.txt";
$komunikat = "";

if (isset($_POST['dodaj'])) {
    $tresc = trim($_POST['tresc']);

    if ($tresc === "") {
        $komunikat = "Notatka nie może być pusta!";
    } else {
        $data = date("[Y-m-d H:i:s] ");
        $linia = $data . $tresc . PHP_EOL;

        if (file_put_contents($plik, $linia, FILE_APPEND)) {
            $komunikat = "Notatka została zapisana.";
        } else {
            $komunikat = "Błąd zapisu do pliku.";
        }
    }
}

if (isset($_POST['usun'])) {
    if (file_exists($plik)) {
        if (unlink($plik)) {
            $komunikat = "Wszystkie notatki zostały usunięte.";
        } else {
            $komunikat = "Nie udało się usunąć pliku.";
        }
    } else {
        $komunikat = "Brak pliku z notatkami.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System notatek</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<h1>System notatek</h1>
<nav>
    <button onclick="pokazSekcje('dodaj')">Dodaj notatkę</button>
    <button onclick="pokazSekcje('lista')">Wszystkie notatki</button>
    <button onclick="pokazSekcje('usun')">Usuń notatki</button>
</nav>
<p id="kom"><?php echo $komunikat; ?></p>
<hr>
<div id="dodaj" class="sekcja">
<h2>Dodaj notatkę</h2>
<form method="post">
    <textarea name="tresc" rows="4" cols="50"></textarea><br><br>
    <button type="submit" name="dodaj">Dodaj</button>
</form>
</div>

<div id="lista" class="sekcja">
<h2>Wszystkie notatki</h2>

<?php
if (!file_exists($plik) || filesize($plik) == 0) {
    echo "<p>Brak notatek.</p>";
} else {
    $linie = file($plik);
    echo "<ol>";
    foreach ($linie as $linia) {
        echo "<li>" . htmlspecialchars($linia) . "</li>";
    }
    echo "</ol>";
}
?>
</div>
<div  id="usun" class="sekcja">
<h2>Usuń wszystkie notatki</h2>
<form method="post">
    <button type="submit" name="usun">Usuń wszystkie</button>
</form>
</div>

<script>
function pokazSekcje(id) {
    const sekcje = document.querySelectorAll('.sekcja');
    
    sekcje.forEach(sekcja => {
        sekcja.classList.remove('aktywna');
    });

    document.getElementById(id).classList.add('aktywna');
}

// domyślnie pokaż pierwszą sekcję
window.onload = function() {
    pokazSekcje('dodaj');
}
</script>
</body>
</html>