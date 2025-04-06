<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap" rel="stylesheet"> <!-- Tambahkan ini -->
    <style>
        @font-face {
            font-family: 'AlexBrush';
            src: url('{{ storage_path('fonts/AlexBrush-Regular.ttf') }}') format('truetype');
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #0a0723;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .certificate-container {
            background-color: #ffffff;
            border: 5px solid #2f6a62;
            border-radius: 10px;
            padding: 40px;
            width: 600px;
            text-align: center;
        }
        .certificate-header {
            font-size: 24pt;
            font-weight: bold;
            color: #2f6a62;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .certificate-subtitle {
            font-size: 12pt;
            color: #6a6f7c;
            margin-bottom: 20px;
        }
        .certificate-name {
            font-size: 18pt;
            font-weight: bold;
            color: #0a0723;
            margin-bottom: 10px;
        }
        .certificate-course {
            font-size: 14pt;
            font-weight: bold;
            color: #2f6a62;
            margin-bottom: 20px;
        }
        .certificate-date {
            font-size: 12pt;
            color: #6a6f7c;
            margin-bottom: 40px;
        }
        .signature {
            margin-top: 30px;
            font-size: 20pt; /* Ukuran font lebih besar untuk tanda tangan */
            color: #6a6f7c;
            font-family: 'AlexBrush', cursive; /* Terapkan font Alex Brush */
            text-align: center;
        }
        .signature-line {
            margin-top: 10px;
            border-top: 1px solid #2f6a62;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .logo {
            width: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <img src="{{ public_path('assets/images/logos/logo-64-big.png') }}" alt="Logo" class="logo">
        <h1 class="certificate-header">Certificate of Completion</h1>
        <p class="certificate-subtitle">This is to certify that</p>
        <h2 class="certificate-name">{{ $userName }}</h2>
        <p class="certificate-subtitle">has successfully completed the course</p>
        <h3 class="certificate-course">{{ $courseName }}</h3>
        <p class="certificate-date">on {{ $completionDate }}</p>
        <div class="signature">
            <p>{{ $mentorName }}</p>
            <div class="signature-line"></div>
        </div>
    </div>
</body>
</html>