<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

function e($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

$name = e($_POST['name'] ?? '');
$birthdate = e($_POST['birthdate'] ?? '');
$email = e($_POST['email'] ?? '');
$phone = e($_POST['phone'] ?? '');

$idade = '';
if ($birthdate) {
    $nascimento = new DateTime($birthdate);
    $hoje = new DateTime();
    $idade = $hoje->diff($nascimento)->y;
}

$education = $_POST['education_course'] ?? [];
$institution = $_POST['education_institution'] ?? [];
$year = $_POST['education_year'] ?? [];
$companies = $_POST['experience_company'] ?? [];
$roles = $_POST['experience_role'] ?? [];
$periods = $_POST['experience_period'] ?? [];
$references = $_POST['reference_name'] ?? [];
$contacts = $_POST['reference_contact'] ?? [];
$skills = e($_POST['skills'] ?? '');
$languages = $_POST['language_name'] ?? [];
$levels = $_POST['language_level'] ?? [];

$html = "
<html>
<head>
<style>
body { font-family: DejaVu Sans, sans-serif; margin: 40px; }
h1 { text-align: center; color: #1e3a8a; }
h2 { color: #1e40af; border-bottom: 1px solid #3b82f6; padding-bottom: 4px; }
p, li { font-size: 14px; line-height: 1.6; }
ul { list-style-type: none; padding-left: 0; }
li { margin-bottom: 6px; }
</style>
</head>
<body>
<h1>Currículo Profissional</h1>

<h2>Dados Pessoais</h2>
<p><strong>Nome:</strong> $name</p>
<p><strong>Data de nascimento:</strong> $birthdate ($idade anos)</p>
<p><strong>Email:</strong> $email</p>
<p><strong>Telefone:</strong> $phone</p>

<h2>Formação Acadêmica</h2>
<ul>";
for ($i = 0; $i < count($education); $i++) {
    $html .= "<li><strong>{$education[$i]}</strong> - {$institution[$i]} ({$year[$i]})</li>";
}
$html .= "</ul>

<h2>Experiências Profissionais</h2>
<ul>";
for ($i = 0; $i < count($companies); $i++) {
    $html .= "<li><strong>{$companies[$i]}</strong> - {$roles[$i]} ({$periods[$i]})</li>";
}
$html .= "</ul>

<h2>Referências Pessoais</h2>
<ul>";
for ($i = 0; $i < count($references); $i++) {
    $html .= "<li><strong>{$references[$i]}</strong> - Contato: {$contacts[$i]}</li>";
}
$html .= "</ul>";

if (!empty($skills)) {
    $html .= "<h2>Habilidades e Competências</h2><p>$skills</p>";
}

if (!empty($languages)) {
    $html .= "<h2>Idiomas</h2><ul>";
    for ($i = 0; $i < count($languages); $i++) {
        $html .= "<li><strong>{$languages[$i]}</strong> - {$levels[$i]}</li>";
    }
    $html .= "</ul>";
}

$html .= "</body></html>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("curriculo_$name.pdf", ["Attachment" => true]);
exit;
?>
