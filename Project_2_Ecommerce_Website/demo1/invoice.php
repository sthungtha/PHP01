<?php
$orderId = $_GET['order_id'] ?? 'N/A';

// Simple PDF generation using TCPDF-like header (no external library needed for demo)
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="invoice_'.$orderId.'.pdf"');

// Basic PDF structure
echo "%PDF-1.3\n";
echo "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
echo "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
echo "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R >>\nendobj\n";
echo "4 0 obj\n<< /Length 450 >>\nstream\n";
echo "BT\n";
echo "/F1 24 Tf 100 700 Td (MY SHOP INVOICE) Tj ET\n";
echo "BT /F1 14 Tf 100 650 Td (Order #: $orderId) Tj ET\n";
echo "BT /F1 12 Tf 100 600 Td (Date: " . date("Y-m-d H:i:s") . ") Tj ET\n";
echo "BT /F1 12 Tf 100 550 Td (Thank you for shopping with us!) Tj ET\n";
echo "BT /F1 10 Tf 100 500 Td (This is a real generated PDF invoice for demo purposes.) Tj ET\n";
echo "BT /F1 10 Tf 100 470 Td (Payment Method: PayPal Sandbox) Tj ET\n";
echo "BT /F1 10 Tf 100 440 Td (Status: Completed) Tj ET\n";
echo "endstream\nendobj\n";
echo "xref\n0 5\n0000000000 65535 f \n";
echo "trailer << /Size 5 /Root 1 0 R >>\nstartxref\n450\n%%EOF\n";
?>
