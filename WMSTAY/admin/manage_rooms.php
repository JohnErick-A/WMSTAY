<?php
require_once '../includes/db_connect.php';
require_once '../includes/auth.php';
require_login();
if (!is_admin()) { header('Location: /WMSTAY/index.php'); exit; }
$title = "Manage Rooms";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
    $room_number = $_POST['room_number'];
    $capacity = (int)$_POST['capacity'];
    $room_type = $_POST['room_type'];
    $stmt = $pdo->prepare("INSERT INTO rooms (building_id, room_number, capacity, room_type, status) VALUES (1,?,?,?,'available')");
    $stmt->execute([$room_number, $capacity, $room_type]);
    header('Location: manage_rooms.php'); exit;
}
$rooms = $pdo->query("SELECT r.*, b.name as building FROM rooms r LEFT JOIN buildings b ON r.building_id = b.building_id ORDER BY r.room_number")->fetchAll(PDO::FETCH_ASSOC);
include '../includes/header.php';
?>
<div class="card">
  <h3>Rooms <button class="btn small" id="showAddRoom">Add Room</button></h3>
  <div id="addRoomForm" class="hidden">
    <form method="post" class="form-inline">
      <input name="room_number" placeholder="Room Number" required>
      <input name="capacity" type="number" placeholder="Capacity" value="1" required>
      <select name="room_type">
        <option value="single">Single</option>
        <option value="double">Double</option>
        <option value="triple">Triple</option>
      </select>
      <button name="add_room" class="btn primary">Add</button>
    </form>
  </div>
  <table class="table"><thead><tr><th>#</th><th>Room</th><th>Type</th><th>Capacity</th><th>Status</th></tr></thead><tbody><?php foreach($rooms as $r): ?><tr><td><?= $r['room_id'] ?></td><td><?= htmlspecialchars($r['room_number']) ?></td><td><?= htmlspecialchars($r['room_type']) ?></td><td><?= $r['capacity'] ?></td><td><?= htmlspecialchars($r['status']) ?></td></tr><?php endforeach; ?></tbody></table>
</div>
<?php echo '</section></main></div></body></html>'; ?>