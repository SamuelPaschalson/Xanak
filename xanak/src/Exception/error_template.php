<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
</head>
<body>
    
<style>
    body { font-family: Arial, sans-serif; }
    .error-container { padding: 20px; border: 1px solid #ccc; background: #f8d7da; color: #721c24; margin: 20px; }
    .code { background: #f4f4f4; padding: 10px; border: 1px solid #ddd; margin: 10px 0; }
    .code-line { padding: 0 10px; }
    .code-line span { display: inline-block; width: 30px; }
</style>
<div class="error-container">
    <h1>An error occurred</h1>
    <p><strong>Message:</strong> <?php echo htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
    <p><strong>File:</strong> <?php echo htmlspecialchars($exception->getFile(), ENT_QUOTES, 'UTF-8'); ?></p>
    <p><strong>Line:</strong> <?php echo htmlspecialchars($exception->getLine(), ENT_QUOTES, 'UTF-8'); ?></p>
    <div class="code">
        <?php foreach ($codeSnippet as $lineNumber => $lineContent): ?>
            <div class="code-line"><span><?php echo $lineNumber + 1; ?></span><?php echo htmlspecialchars($lineContent, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endforeach; ?>
    </div>
    <pre><strong>Trace:</strong> <?php echo htmlspecialchars($exception->getTraceAsString(), ENT_QUOTES, 'UTF-8'); ?></pre>
</div>
</body>
</html>
