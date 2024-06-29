<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Editor</title>
    <link rel="stylesheet" href="styles.css">
    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f0f0;
}

.editor-container {
    width: 80%;
    max-width: 800px;
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.toolbar {
    display: flex;
    justify-content: space-around;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

#editor {
    height: 500px;
    padding: 20px;
    font-size: 16px;
    overflow-y: auto;
}
</style>
</head>
<body>
    <div class="editor-container">
        <div class="toolbar">
            <select id="fontSelect">
                <option value="Arial">Arial</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Verdana">Verdana</option>
                <!-- Add more fonts as needed -->
            </select>
            <input type="number" id="fontSize" min="8" max="72" value="16"> px
            <input type="color" id="fontColor">
        </div>
        <div id="editor" contenteditable="true" class="editor"></div>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
