<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Database Assistant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .loader {
            width: 48px;
            height: 48px;
            border: 5px solid #2c3e50;
            border-bottom-color: transparent;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .toggle-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 1.5em;
        }

        .toggle-option input[type="radio"] {
            display: none;
        }

        .toggle-option label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            background-color: #f5f5f5;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            color: #666;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            user-select: none;
            position: relative;
        }

        .toggle-option label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scale(0);
            width: 4px;
            height: 70%;
            background-color: #2c3e50;
            border-radius: 0 2px 2px 0;
            transition: transform 0.3s ease;
        }

        .toggle-option label i {
            font-size: 1.1em;
            transition: transform 0.3s ease;
        }

        .toggle-option input[type="radio"]:checked+label {
            background-color: #edf2f7;
            border-color: #2c3e50;
            color: #2c3e50;
            padding-left: 28px;
            font-weight: 600;
        }

        .toggle-option input[type="radio"]:checked+label:before {
            transform: translateY(-50%) scale(1);
        }

        .toggle-option input[type="radio"]:checked+label i {
            transform: scale(1.2);
            color: #2c3e50;
        }

        .toggle-option label:hover {
            background-color: #edf2f7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .toggle-option input[type="radio"]:checked+label:hover {
            transform: translateY(-1px);
        }
    </style>
</head>

<body style="background-color: #f5f5f5; margin: 0; font-family: 'Segoe UI', Arial, sans-serif; color: #333;">
    <div style="max-width: 800px; margin: 2em auto; padding: 0 20px;">
        <header style="text-align: center; margin-bottom: 2em;">
            <h1 style="color: #2c3e50; font-size: 2.5em; margin-bottom: 0.5em;">HR Database Assistant</h1>
            <p style="color: #7f8c8d; font-size: 1.1em; margin-top: 0;">Powered by OpenRouter AI</p>
        </header>

        <!-- Form Prompting -->
        <form id="apiForm"
            style="background-color: white; padding: 2em; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <textarea id="queryInput" placeholder="Ask anything about the HR database..." required
                style="width: 100%;
                       min-height: 100px;
                       padding: 1em;
                       border: 2px solid #e0e0e0;
                       border-radius: 8px;
                       font-size: 1em;
                       margin-bottom: 1em;
                       resize: vertical;
                       font-family: inherit;
                       box-sizing: border-box;
                       transition: border-color 0.3s ease;"
                onfocus="this.style.borderColor='#2c3e50'"
                onblur="this.style.borderColor='#e0e0e0'"></textarea>

            <div class="toggle-container">
                <div class="toggle-option">
                    <input type="radio" id="hasil" name="outputType" value="hasil" checked>
                    <label for="hasil">
                        <i class="fas fa-table"></i>
                        <span>Show Result</span>
                    </label>
                </div>
                <div class="toggle-option">
                    <input type="radio" id="queryType" name="outputType" value="query">
                    <label for="queryType">
                        <i class="fas fa-code"></i>
                        <span>Show Query</span>
                    </label>
                </div>
            </div>

            <button
                type="submit"
                style="width: 100%;
                       padding: 1em;
                       background-color: #2c3e50;
                       color: white;
                       border: none;
                       border-radius: 8px;
                       font-size: 1em;
                       cursor: pointer;
                       transition: background-color 0.3s ease;"
                onmouseover="this.style.backgroundColor='#34495e'"
                onmouseout="this.style.backgroundColor='#2c3e50'">Get Answer</button>
        </form>

        <!-- Result Container -->
        <div style="margin-top: 2em;
                    background-color: white;
                    border-radius: 10px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    overflow: hidden;">
            <div style="padding: 1em;
                        border-bottom: 2px solid #f5f5f5;
                        color: #2c3e50;
                        font-weight: bold;">
                Response
            </div>
            <div id="result"
                style="padding: 1.5em;
                        min-height: 200px;
                        max-height: 500px;
                        overflow-y: auto;
                        line-height: 1.6;">
            </div>
        </div>
    </div>
    <script src="fetch.js"></script>
</body>

</html>