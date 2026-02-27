<?php
require_once 'config.php';
$sql    = "SELECT * FROM users ORDER BY registration_date DESC";
$result = $conn->query($sql);
$count  = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Registrations - EventReg</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.html"><i class="fas fa-calendar-check"></i> EventReg</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="events.html">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="faq.html">FAQ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section style="padding:60px 0;background:var(--bg-light);min-height:85vh;">
        <div class="container">
            <div style="background:white;border-radius:var(--radius-xl);box-shadow:var(--shadow-lg);overflow:hidden;">

                <!-- Header -->
                <div class="admin-header">
                    <div class="row align-items-center position-relative" style="z-index:1;">
                        <div class="col-md-8">
                            <h2 style="color:white;font-size:28px;margin-bottom:6px;"><i class="fas fa-clipboard-list me-3"></i>All Registrations</h2>
                            <p style="color:rgba(255,255,255,0.8);margin:0;font-size:15px;">View and manage all event registrations</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div style="background:rgba(255,255,255,0.2);border-radius:var(--radius-lg);padding:16px 24px;display:inline-block;">
                                <div style="color:white;font-size:32px;font-weight:800;line-height:1;"><?php echo $count; ?></div>
                                <div style="color:rgba(255,255,255,0.8);font-size:13px;letter-spacing:1px;">TOTAL REGISTRATIONS</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div style="padding:30px;">
                    <div class="d-flex gap-3 mb-4 flex-wrap">
                        <a href="register.html" class="btn btn-primary"><i class="fas fa-plus me-2"></i>New Registration</a>
                        <a href="index.html" class="btn" style="background:var(--bg-light);color:var(--text-primary);border:2px solid var(--border);"><i class="fas fa-home me-2"></i>Back to Home</a>
                    </div>

                    <?php if ($count > 0): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Event</th>
                                        <th>Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><span style="background:var(--gradient);color:white;padding:4px 10px;border-radius:50px;font-size:12px;font-weight:700;"><?php echo $row['id']; ?></span></td>
                                        <td style="font-weight:600;color:var(--text-primary);"><?php echo htmlspecialchars($row['full_name']); ?></td>
                                        <td style="color:var(--text-secondary);"><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td style="color:var(--text-secondary);"><?php echo htmlspecialchars($row['phone']); ?></td>
                                        <td>
                                            <span style="background:rgba(99,102,241,0.1);color:var(--primary);padding:5px 12px;border-radius:50px;font-size:13px;font-weight:600;">
                                                <?php echo htmlspecialchars($row['event_name']); ?>
                                            </span>
                                        </td>
                                        <td style="color:var(--text-secondary);font-size:14px;"><?php echo date('d M Y, h:i A', strtotime($row['registration_date'])); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="text-align:center;padding:60px 20px;">
                            <div style="width:80px;height:80px;background:var(--bg-light);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:36px;color:var(--text-muted);">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h4 style="color:var(--text-primary);margin-bottom:8px;">No Registrations Yet</h4>
                            <p style="color:var(--text-secondary);margin-bottom:24px;">Be the first one to register for an event!</p>
                            <a href="register.html" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Register Now</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container text-center">
            <div class="footer-brand"><i class="fas fa-calendar-check me-2"></i>EventReg</div>
            <hr class="footer-divider">
            <p>&copy; 2026 EventReg. All rights reserved. &nbsp;|&nbsp; <a href="index.html">Home</a> &nbsp;|&nbsp; <a href="contact.html">Contact</a> &nbsp;|&nbsp; <a href="faq.html">FAQ</a></p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
<?php $conn->close(); ?>