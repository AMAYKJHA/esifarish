<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $sifarishType = $_POST['sifarishType'] ?? '';
    $fullNameNp = $_POST['fullNameNp'] ?? '';
    $fullNameEn = $_POST['fullNameEn'] ?? '';
    $dob_bs = $_POST['dob_bs'] ?? '';
    $dob_ad = $_POST['dob_ad'] ?? '';
    $citizenNo = $_POST['citizenNo'] ?? '';
    $cit_bs = $_POST['cit_bs'] ?? '';
    $cit_ad = $_POST['cit_ad'] ?? '';
    $ageGroup = $_POST['ageGroup'] ?? '';
    $district_id = $_POST['district_id'] ?? '';
    $mobile_no = $_POST['mobile_no'] ?? '';

    // Handle file uploads
    $citizenship_front = '';
    $citizenship_back = '';
    $documents = [];
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (isset($_FILES['citizenship_front']) && $_FILES['citizenship_front']['error'] === UPLOAD_ERR_OK) {
        $citizenship_front = $uploadDir . basename($_FILES['citizenship_front']['name']);
        move_uploaded_file($_FILES['citizenship_front']['tmp_name'], $citizenship_front);
    }
    if (isset($_FILES['citizenship_back']) && $_FILES['citizenship_back']['error'] === UPLOAD_ERR_OK) {
        $citizenship_back = $uploadDir . basename($_FILES['citizenship_back']['name']);
        move_uploaded_file($_FILES['citizenship_back']['tmp_name'], $citizenship_back);
    }
    if (isset($_FILES['documents'])) {
        foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['documents']['error'][$key] === UPLOAD_ERR_OK) {
                $filePath = $uploadDir . basename($_FILES['documents']['name'][$key]);
                move_uploaded_file($tmp_name, $filePath);
                $documents[] = $filePath;
            }
        }
    }

    // Insert into applications table
    $stmt = $conn->prepare('INSERT INTO applications (user_id, sifarish_type, full_name_np, full_name_en, dob_bs, dob_ad, citizen_no, cit_bs, cit_ad, age_group, district_id, mobile_no, citizenship_front, citizenship_back, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $user_id = $_SESSION['user_id'] ?? null;
    $status = 'Pending';
    $stmt->bind_param('issssssssssssss', $user_id, $sifarishType, $fullNameNp, $fullNameEn, $dob_bs, $dob_ad, $citizenNo, $cit_bs, $cit_ad, $ageGroup, $district_id, $mobile_no, $citizenship_front, $citizenship_back, $status);
    if ($stmt->execute()) {
        $application_id = $stmt->insert_id;
        // Optionally insert documents
        foreach ($documents as $docPath) {
            $docStmt = $conn->prepare('INSERT INTO documents (user_id, file_name, file_path) VALUES (?, ?, ?)');
            $fileName = basename($docPath);
            $docStmt->bind_param('iss', $user_id, $fileName, $docPath);
            $docStmt->execute();
            $docStmt->close();
        }
        $stmt->close();
        header('Location: ../success.html');
        exit();
    } else {
        echo 'Error submitting application.';
    }
}
?>
