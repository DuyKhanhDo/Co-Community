<div class="container-fluid dashboard">
    <div class="dashboard-header">
        <h1>Bảng điều khiển</h1>
        <p>Xin chào, <?php echo isset($user) ? $user['name'] : 'Admin'; ?>!</p>
    </div>

    <div class="row stats">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="fas fa-film"></i>
                    </div>
                    <div class="stat-card-info">
                        <h5>Tổng số phim</h5>
                        <h2><?php echo isset($stats['total_movies']) ? $stats['total_movies'] : 0; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-card-info">
                        <h5>Người dùng</h5>
                        <h2><?php echo isset($stats['total_users']) ? $stats['total_users'] : 0; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-card-info">
                        <h5>Lượt xem</h5>
                        <h2><?php echo isset($stats['total_views']) ? $stats['total_views'] : 0; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="stat-card-info">
                        <h5>Thể loại</h5>
                        <h2><?php echo isset($stats['total_categories']) ? $stats['total_categories'] : 0; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card recent-movies">
                <div class="card-header">
                    <h4>Phim mới thêm gần đây</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tiêu đề</th>
                                    <th>Thể loại</th>
                                    <th>Ngày thêm</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($recent_movies) && !empty($recent_movies)): ?>
                                    <?php foreach ($recent_movies as $movie): ?>
                                        <tr>
                                            <td><?php echo $movie['title']; ?></td>
                                            <td><?php echo $movie['category']; ?></td>
                                            <td><?php echo $movie['date_added']; ?></td>
                                            <td>
                                                <span class="status-badge status-<?php echo strtolower($movie['status']); ?>">
                                                    <?php echo $movie['status']; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Không có phim mới nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card activity-log">
                <div class="card-header">
                    <h4>Hoạt động gần đây</h4>
                </div>
                <div class="card-body">
                    <ul class="activity-list">
                        <?php if (isset($recent_activities) && !empty($recent_activities)): ?>
                            <?php foreach ($recent_activities as $activity): ?>
                                <li class="activity-item">
                                    <span class="activity-icon">
                                        <i class="fas fa-<?php echo $activity['icon']; ?>"></i>
                                    </span>
                                    <div class="activity-info">
                                        <p><?php echo $activity['message']; ?></p>
                                        <small><?php echo $activity['time']; ?></small>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="activity-item">
                                <div class="activity-info">
                                    <p>Không có hoạt động nào gần đây</p>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>