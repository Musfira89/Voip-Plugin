<?php
$dummyCalls = [
    [
        "id" => 1,
        "caller" => "John Doe",
        "receiver" => "Jane Smith",
        "direction" => "inbound",
        "status" => "completed",
        "duration" => "02:34",
        "timestamp" => "2025-08-01 12:30:00",
        "recordingUrl" => "http://localhost:8000/recordings/call1.mp3"
    ],
    [
        "id" => 2,
        "caller" => "Agent 007",
        "receiver" => "HQ",
        "direction" => "outbound",
        "status" => "missed",
        "duration" => "00:00",
        "timestamp" => "2025-08-01 14:20:00",
        "recordingUrl" => null
    ],
    [
        "id" => 3,
        "caller" => "Alice",
        "receiver" => "Bob",
        "direction" => "inbound",
        "status" => "completed",
        "duration" => "03:45",
        "timestamp" => "2025-08-01 15:00:00",
        "recordingUrl" => "http://localhost:8000/recordings/call3.mp3"
    ],
    [
        "id" => 4,
        "caller" => "Charlie",
        "receiver" => "Delta",
        "direction" => "outbound",
        "status" => "completed",
        "duration" => "01:20",
        "timestamp" => "2025-08-01 16:10:00",
        "recordingUrl" => "http://localhost:8000/recordings/call4.mp3"
    ],
    [
        "id" => 5,
        "caller" => "Eve",
        "receiver" => "Mallory",
        "direction" => "inbound",
        "status" => "missed",
        "duration" => "00:00",
        "timestamp" => "2025-08-01 17:30:00",
        "recordingUrl" => null
    ],
    [
        "id" => 6,
        "caller" => "Frank",
        "receiver" => "Grace",
        "direction" => "outbound",
        "status" => "completed",
        "duration" => "04:10",
        "timestamp" => "2025-08-01 18:00:00",
        "recordingUrl" => "http://localhost:8000/recordings/call6.mp3"
    ],
    [
        "id" => 7,
        "caller" => "Heidi",
        "receiver" => "Ivan",
        "direction" => "inbound",
        "status" => "completed",
        "duration" => "02:22",
        "timestamp" => "2025-08-01 18:45:00",
        "recordingUrl" => "http://localhost:8000/recordings/call7.mp3"
    ],
    [
        "id" => 8,
        "caller" => "Judy",
        "receiver" => "Ken",
        "direction" => "outbound",
        "status" => "completed",
        "duration" => "05:50",
        "timestamp" => "2025-08-01 19:15:00",
        "recordingUrl" => "http://localhost:8000/recordings/call8.mp3"
    ],
    [
        "id" => 9,
        "caller" => "Leo",
        "receiver" => "Nina",
        "direction" => "inbound",
        "status" => "missed",
        "duration" => "00:00",
        "timestamp" => "2025-08-01 20:00:00",
        "recordingUrl" => null
    ],
    [
        "id" => 10,
        "caller" => "Oscar",
        "receiver" => "Peggy",
        "direction" => "outbound",
        "status" => "completed",
        "duration" => "03:30",
        "timestamp" => "2025-08-01 21:10:00",
        "recordingUrl" => "http://localhost:8000/recordings/call10.mp3"
    ],
    [
        "id" => 11,
        "caller" => "Quinn",
        "receiver" => "Rita",
        "direction" => "inbound",
        "status" => "completed",
        "duration" => "01:50",
        "timestamp" => "2025-08-01 22:00:00",
        "recordingUrl" => "http://localhost:8000/recordings/call11.mp3"
    ],
    [
        "id" => 12,
        "caller" => "Sam",
        "receiver" => "Trudy",
        "direction" => "outbound",
        "status" => "missed",
        "duration" => "00:00",
        "timestamp" => "2025-08-01 22:45:00",
        "recordingUrl" => null
    ]
];

// Return dummy data as JSON
echo json_encode($dummyCalls);
