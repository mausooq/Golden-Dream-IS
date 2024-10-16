<!-- Add-Faqs.php -->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
                        <a class="nav-link" href="../Faqs/Add-Faqs.php">
                            <i class="bi bi-chat"></i> FAQs
                            <span class="badge bg-soft-primary text-primary rounded-pill d-inline-flex align-items-center ms-auto">4</span>
                        </a>
                    </li>
                    <!-- Other navigation items -->
                </ul>
                <!-- Divider -->
                <hr class="navbar-divider my-5 opacity-20">
                <!-- User menu -->
                <ul class="navbar-nav">
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
                            <h1 class="h2 mb-0 ls-tight">Add FAQs</h1>
                        </div>
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
                                    <span>Create</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Nav -->
                    <ul class="nav nav-tabs mt-4 overflow-x border-0">
                        <li class="nav-item">
                            <a href="./Faqs.php" class="nav-link font-regular">FAQs</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Add New</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <div class="container">
            <div class="container mt-5">
                <form action="insert_Faqs.php" method="POST">
                    <div class="mb-3">
                        <label for="faqQuestion" class="form-label">Question</label>
                        <textarea class="form-control" id="faqQuestion" name="faq_question" placeholder="Enter the question" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="faqAnswer" class="form-label">Answer</label>
                        <textarea class="form-control" id="faqAnswer" name="faq_answer" placeholder="Enter the answer" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="sortOrder" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sortOrder" name="sort_order" placeholder="Enter sort order" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add FAQ</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
