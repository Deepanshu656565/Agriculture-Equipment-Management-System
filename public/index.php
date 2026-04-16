<?php
require_once __DIR__ . '/../includes/header.php';

// Fetch all equipment ordered by newest first
$q = $conn->query("SELECT * FROM equipment ORDER BY created_at DESC");
?>

<h1 class="mb-4">Available Equipment</h1>

<div class="row g-3">
    <?php while ($row = $q->fetch_assoc()): ?>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <!-- Corrected Image Path -->
                <img src="/agri_rental_full/public/images/<?= e($row['image']) ? e($row['image']) : 'no-image.png' ?>" 
                     class="card-img-top" 
                     alt="<?= e($row['name']) ?>">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= e($row['name']) ?></h5>
                    <p class="card-text small text-muted"><?= e(substr($row['description'], 0, 100)) ?>...</p>
                    
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="badge bg-success">₹<?= e($row['price_per_day']) ?>/day</span>
                        <a class="btn btn-outline-success btn-sm" href="/agri_rental_full/public/equipment.php?id=<?= $row['id'] ?>">View</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
