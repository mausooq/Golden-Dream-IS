<?php
include("../config.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch FAQs
$sql = "SELECT question, answer FROM faqs ORDER BY sort_order ASC"; // Make sure 'sort_order' or another existing column is used
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<link rel="stylesheet" href="../style.css">

<body>
    <!-- Dashboard -->
    <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
        <!-- Vertical Navbar -->
        <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg" id="navbarVertical">
            <div class="container-fluid">
                <!-- Toggler -->
                <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Brand -->
                <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0" href="#">
                    <img src="../images/gdlogo.png" alt="...">
                    GD Gold & Diamonds
                </a>
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidebarCollapse">
                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../Trending_Collections/TrendingCollections.php">
                                <i class="bi bi-bar-chart"></i>Trending Collections
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../Collections/Collections.php">
                                <i class="bi bi-chat"></i> Collections
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../CollectionItems/CollectionItems.php">
                                <i class="bi bi-bookmarks"></i> Collection Items
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link active" href="Faqs.php">
                                <i class="bi bi-question-circle"></i> Faqs
                            </a>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="navbar-divider my-5 opacity-20">

                    <!-- User menu -->
                    <ul class="navbar-nav mt-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-person-square"></i> Account
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <div class="h-screen flex-grow-1 overflow-y-lg-auto">
            <!-- Header -->
            <header class="bg-surface-primary border-bottom pt-6">
                <div class="container-fluid">
                    <div class="mb-npx">
                        <div class="row align-items-center">
                            <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                                <!-- Title -->
                                <h1 class="h2 mb-0 ls-tight">FAQs</h1>
                            </div>
                            <!-- Actions -->
                            <div class="col-sm-6 col-12 text-sm-end">
                                <div class="mx-n1">
                                    <a href="#" class="btn d-inline-flex btn-sm btn-neutral border-base mx-1">
                                        <span class="pe-2">
                                            <i class="bi bi-pencil"></i>
                                        </span>
                                        <span>Edit</span>
                                    </a>
                                    <a href="#" class="btn d-inline-flex btn-sm btn-primary mx-1">
                                        <span class="pe-2">
                                            <i class="bi bi-plus"></i>
                                        </span>
                                        <span>Add FAQ</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Nav -->
                        <ul class="nav nav-tabs mt-4 overflow-x border-0">
                            <li class="nav-item">
                                <a href="#" class="nav-link active">FAQ List</a>
                            </li>
                            <li class="nav-item">
                                <a href="./Add-Faqs.php" class="nav-link font-regular">Add New</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Main -->
            <div class="container mt-5">
                <div class="row">
                    <?php
                    if ($result === FALSE) {
                        echo "<p>Error fetching data: " . $conn->error . "</p>";
                    } elseif ($result->num_rows > 0) {
                        // Display FAQs if present
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['question']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($row['answer']); ?></p>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        // If no FAQs found
                        echo "<p>There are no FAQs currently.</p>";
                    }
                    ?>
                </div>
            </div>

            <?php
            $conn->close();
            ?>
            <!-- End of content -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
