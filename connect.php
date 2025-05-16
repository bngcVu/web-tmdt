<?php
ob_start();

try {
    // Kết nối đến cơ sở dữ liệu MySQL sử dụng PDO (PHP Data Objects).
    // Thay đổi 'localhost', 'smobile', 'root', '' nếu thông tin đăng nhập của bạn khác.
    // 'charset=utf8' đảm bảo hỗ trợ tiếng Việt và các ký tự đặc biệt khác.
    $conn = new PDO("mysql:host=localhost;dbname=smobile;charset=utf8", "root", "");

    // Thiết lập chế độ báo lỗi của PDO thành ngoại lệ (exception).
    // Khi có lỗi xảy ra trong quá trình thao tác với cơ sở dữ liệu, PDO sẽ ném ra một ngoại lệ.
    // Điều này giúp bạn bắt và xử lý lỗi một cách rõ ràng hơn.
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Bắt ngoại lệ nếu kết nối cơ sở dữ liệu thất bại.
    // Trong ứng dụng thực tế, bạn nên ghi lại lỗi này vào log thay vì hiển thị trực tiếp cho người dùng.
    echo "Lỗi Kết Nối Cơ Sở Dữ Liệu: " . $e->getMessage();
    // Dừng thực thi script nếu kết nối cơ sở dữ liệu thất bại.
    die();
}

// Hàm hợp nhất để thực thi các truy vấn SQL với tham số.
// Sử dụng prepared statements giúp ngăn chặn tấn công SQL injection.
function execute_query($sql, $params = []) {
    try {
        // Chuẩn bị truy vấn SQL.
        $stmt = $GLOBALS['conn']->prepare($sql);
        // Thực thi truy vấn với các tham số được truyền vào.
        $stmt->execute($params);
        // Trả về đối tượng statement sau khi thực thi thành công.
        return $stmt;
    } catch (PDOException $e) {
        // Xử lý hoặc ghi lại lỗi truy vấn một cách thích hợp.
        // Hiện tại chỉ hiển thị lỗi, nhưng nên xem xét chiến lược xử lý lỗi mạnh mẽ hơn.
        echo "Lỗi Truy Vấn: " . $e->getMessage();
        // Trả về false để chỉ ra rằng truy vấn thất bại.
        return false;
    }
}

// Hàm lấy tất cả các hàng từ kết quả truy vấn SELECT.
// Sử dụng prepared statements.
function selectAll($sql, $params = []) {
    // Thực thi truy vấn.
    $stmt = execute_query($sql, $params);
    // Kiểm tra xem truy vấn có thành công không và có kết quả trả về không.
    // fetchAll(PDO::FETCH_ASSOC) sẽ lấy tất cả các hàng dưới dạng mảng kết hợp.
    // Trả về mảng rỗng nếu truy vấn thất bại hoặc không có kết quả.
    return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
}

// Hàm đếm số lượng hàng bị ảnh hưởng bởi truy vấn (INSERT, UPDATE, DELETE).
// Lưu ý: Đối với truy vấn SELECT, việc sử dụng rowCount() sau fetchAll thường đáng tin cậy hơn
// hoặc sử dụng COUNT(*) trong câu lệnh SQL.
// Hàm này sẽ trả về số lượng hàng bị ảnh hưởng cho INSERT, UPDATE, DELETE.
// Đối với SELECT, nó phụ thuộc vào driver và có thể không đáng tin cậy.
// Cách đáng tin cậy hơn để đếm cho SELECT là sử dụng SELECT COUNT(*) trong SQL.
function rowCount($sql, $params = []) {
    // Thực thi truy vấn.
    $stmt = execute_query($sql, $params);
    // Trả về số lượng hàng bị ảnh hưởng hoặc 0 nếu truy vấn thất bại.
    return $stmt ? $stmt->rowCount() : 0;
}

// Hàm này dùng cho các truy vấn INSERT, UPDATE, DELETE không trả về tập kết quả
// nhưng bạn muốn biết liệu nó có thành công hay không.
function exSQL($sql, $params = []) {
    // Thực thi truy vấn.
    $stmt = execute_query($sql, $params);
    // Trả về true nếu truy vấn thành công (không phải false), false nếu thất bại.
    return $stmt !== false;
}

// Đặt múi giờ mặc định cho script.
date_default_timezone_set('Asia/Ho_Chi_Minh');
// $timestamp = time(); // $today hiện được đặt trong cart.php khi cần cho đơn hàng
// $today = date('d-m-Y H:i:s', $timestamp); // Biến $today toàn cục này có thể không phải lúc nào cũng là thứ bạn cần.
?>




