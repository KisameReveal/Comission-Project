<?php
session_start();
include('db.php');

if ($_SESSION['role'] != 'Applicant') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_job'])) {
    $job_id = $_POST['job_id'];
    $resume_url = 'uploads/' . $_FILES['resume']['name'];

    move_uploaded_file($_FILES['resume']['tmp_name'], $resume_url);

    $stmt = $pdo->prepare("INSERT INTO Applications (job_id, applicant_id, resume_url) VALUES (?, ?, ?)");
    $stmt->execute([$job_id, $_SESSION['user_id'], $resume_url]);

    echo "Application submitted successfully!";
}

?>

<h1>Applicant Dashboard</h1>
<h2>Available Jobs</h2>
<?php
$jobs = $pdo->query("SELECT * FROM JobPosts");

while ($job = $jobs->fetch()) {
    echo "<div><h3>{$job['title']}</h3><p>{$job['description']}</p>";
    echo "<form method='POST' enctype='multipart/form-data'>
            <input type='hidden' name='job_id' value='{$job['id']}'>
            Resume: <input type='file' name='resume' required><br>
            <button type='submit' name='apply_job'>Apply</button>
          </form></div>";
}
?>
