<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Completion Certificate</title>
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'AlexBrush';
            src: url('{{ storage_path('fonts/AlexBrush-Regular.ttf') }}') format('truetype');
        }
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .certificate-container {
            width: 800px;
            height: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 20px solid #2F6A62;
            padding: 50px;
            text-align: center;
            position: relative;
        }
        .logo {
            width: 150px;
            margin-bottom: 30px;
        }
        .certificate-title {
            font-size: 40px;
            font-weight: bold;
            color: #2F6A62;
            margin-bottom: 20px;
        }
        .certificate-subtitle {
            font-size: 24px;
            color: #6c757d;
            margin-bottom: 40px;
        }
        .recipient-name {
            font-size: 32px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
        }
        .course-name {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 40px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }
        .signature {
            width: 40%;
            border-top: 2px solid #343a40;
            padding-top: 10px;
            font-weight: bold;
        }
        .date {
            margin-top: 40px;
            font-size: 18px;
            color: #6c757d;
        }
        .certificate-footer {
            margin-top: 40px;
            font-size: 14px;
            color: #6c757d;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <img src="{{ public_path('assets/images/logo.png') }}" alt="Dialogika Logo" class="logo">
        
        <div class="watermark">
            <img src="{{ public_path('assets/images/logo.png') }}" alt="Watermark" width="400">
        </div>
        
        <div class="certificate-title">Certificate of Completion</div>
        <div class="certificate-subtitle">This certifies that</div>
        
        <div class="recipient-name">{{ $userName }}</div>
        
        <div class="certificate-subtitle">has successfully completed the course</div>
        
        <div class="course-name">{{ $courseName }}</div>
        
        <div class="signatures">
            <div class="signature">
                {{ $mentorName }}
                <br>
                Course Instructor
            </div>
            <div class="signature">
                Dialogika Management
                <br>
                CEO
            </div>
        </div>
        
        <div class="date">Completed on: {{ $completionDate }}</div>
        
        <div class="certificate-footer">
            Certificate ID: DLG-{{ str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT) }}-{{ now()->format('Ymd') }}
        </div>
    </div>
</body>
</html>