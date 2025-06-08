<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <div class="user" style="color:black;font-weight:700;font-size:18px">
            <div class="info">
                <span class="user-level">
                    <?php
                    if (isset($_SESSION['is_employer'])) {
                        echo $_SESSION['is_employer'] ? 'Employer' : 'Candidate';
                    } else {
                        echo 'Guest';
                    }
                    ?>
                </span>
                <span class="caret"></span>
                <div class="clearfix"></div>
            </div>
        </div>

        <ul class="nav" id="sidebar-menu">
            <?php if (isset($_SESSION['is_employer']) && $_SESSION['is_employer']): ?>
            <!-- Employer Menu -->
            <li class="nav-item">
                <a href="employer-dashboard.php">
                    <i class="la la-dashboard"></i>
                    <p>Employer Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="create-job.php">
                    <i class="la la-briefcase"></i>
                    <p>Create a Job Post</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="alljobs.php">
                    <i class="la la-list"></i>
                    <p>All Jobs</p>
                </a>
            </li>
            <?php else: ?>
            <!-- Candidate Menu -->
            <li class="nav-item">
                <a href="candidate-dashboard.php">
                    <i class="la la-dashboard"></i>
                    <p>Candidate Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="applied-jobs.php">
                    <i class="la la-check"></i>
                    <p>Applied Jobs</p>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>