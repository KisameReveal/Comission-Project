<?php
session_start();
include('db.php');

if ($_SESSION['role'] != 'HR') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_job'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO JobPosts (title, description, created_by) VALUES (?, ?, ?)");
    $stmt->execute([$title, $description, $_SESSION['user_id']]);
}

?>

<h1>HR Dashboard</h1>
<form method="POST">
    Job Title: <input type="text" name="title" required><br>
    Description: <textarea name="description" required></textarea><br>
    <button type="submit" name="post_job">Post Job</button>
</form>

<h2>Job Applications</h2>
<?php
$jobs = $pdo->query("SELECT * FROM JobPosts WHERE created_by = {$_SESSION['user_id']}");

while ($job = $jobs->fetch()) {
    echo "<div><h3>{$job['title']}</h3><p>{$job['description']}</p></div>";

    // Show applications for this job
    $apps = $pdo->prepare("SELECT * FROM Applications WHERE job_id = ?");
    $apps->execute([$job['id']]);
    while ($app = $apps->fetch()) {
        echo "<div><p>Applicant ID: {$app['applicant_id']} | Status: {$app['status']}</p></div>";
    }
}
?>
