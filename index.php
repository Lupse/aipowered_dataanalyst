<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Database Assistant</title>
</head>

<body style="background-color: #f5f5f5; margin: 0; font-family: 'Segoe UI', Arial, sans-serif; color: #333;">
    <div style="max-width: 800px; margin: 2em auto; padding: 0 20px;">
        <header style="text-align: center; margin-bottom: 2em;">
            <h1 style="color: #2c3e50; font-size: 2.5em; margin-bottom: 0.5em;">HR Database Assistant</h1>
            <p style="color: #7f8c8d; font-size: 1.1em; margin-top: 0;">Powered by OpenRouter AI</p>
        </header>

        <!-- Form Prompting -->
        <form id="apiForm" style="background-color: white; padding: 2em; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <textarea
                id="query"
                placeholder="Ask anything about the HR database..."
                required
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