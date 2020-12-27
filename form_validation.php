<?php
//Check if data is valid & generate error if not so
$errors = [];
if ($nameTeacher == "") {
    $errors['nameTeacher'] = 'dit veld is verplicht';
}
if ($nameChild == "") {
}
if ($email == "") {
    $errors['email'] = 'dit veld is verplicht';
}

// this error message wil overwrite the previous error when year is empty
if ($date == "") {
    $errors['year'] = 'dit veld is verplicht';
}
if (!is_numeric($ageYear)) {
    $ageYear['ageYear'] = 'dit veld is verplicht';
}
// this error message wil overwrite the previous error when tracks is empty
if ($ageYear == "") {
    $errors['ageYear'] = 'dit veld is verplicht';
}

if (!is_numeric($ageMonth)) {
    $ageMonth['ageMonth'] = 'dit veld is verplicht';
}
// this error message wil overwrite the previous error when tracks is empty
if ($ageMonth == "") {
    $errors['ageMonth'] = 'dit veld is verplicht';
}

