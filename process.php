<?php
header("Content-Type: application/json");

try {
    $jsonFile = "../backend/form_data.json";

    
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if the request is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize inputs
        $feedbackType = htmlspecialchars($data['feedbackType'] ?? '');
        $filterCategory = htmlspecialchars($data['filterCategory'] ?? '');
        $feedbackMessage = htmlspecialchars($data['feedbackMessage'] ?? '');

        if (!empty($feedbackType) && !empty($filterCategory) && !empty($feedbackMessage)) {
            $formEntry = [
                'feedbackType' => $feedbackType,
                'filterCategory' => $filterCategory,
                'feedbackMessage' => $feedbackMessage,
                'timestamp' => date("Y-m-d H:i:s"),
            ];

            if (file_exists($jsonFile)) {
                $existingData = json_decode(file_get_contents($jsonFile), true);
                if (!is_array($existingData)) {
                    $existingData = [];
                }
            } else {
                $existingData = [];
            }

            $existingData[] = $formEntry;

            if (file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT))) {
                echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save feedback data.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
