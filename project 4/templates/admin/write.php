<!DOCTYPE html>
<html lang="ru" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Новая статья — Блог</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        body { background-color: #0d0f1a; }
        .form-card { background: #1a1d27; border: 1px solid #2e3250; border-radius: 12px; }
        .ql-toolbar { background: #0d0f1a; border-color: #2e3250 !important; border-radius: 8px 8px 0 0; }
        .ql-container { background: #13151f; border-color: #2e3250 !important; border-radius: 0 0 8px 8px; min-height: 320px; }
        .ql-editor { color: #e2e8f0; font-size: 1rem; min-height: 300px; }
        .ql-editor.ql-blank::before { color: #4a5568; }
        .ql-stroke { stroke: #94a3b8 !important; }
        .ql-fill { fill: #94a3b8 !important; }
        .ql-picker-label { color: #94a3b8 !important; }
        .ql-picker-options { background: #1a1d27 !important; border-color: #2e3250 !important; }
        .ql-picker-item { color: #e2e8f0 !important; }
        .ql-active .ql-stroke { stroke: #7dd3fc !important; }
        .ql-active .ql-fill { fill: #7dd3fc !important; }
    </style>
</head>
<body class="p-4">
<div class="container" style="max-width: 860px;">

    <h1 class="text-white mb-1">Новая статья</h1>
    <a href="?page=admin" class="btn btn-outline-secondary btn-sm mb-4">← Назад</a>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="POST" id="articleForm" class="form-card p-4">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3">
            <label for="title" class="form-label text-secondary">Заголовок <span class="text-danger">*</span></label>
            <input type="text" id="title" name="title" class="form-control" required placeholder="Заголовок статьи">
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label text-secondary">Теги <span class="text-secondary small">(через запятую)</span></label>
            <input type="text" id="tags" name="tags" class="form-control" placeholder="PHP, Web, Tutorial">
        </div>

        <div class="mb-3">
            <label for="editor" class="form-label text-secondary">Текст статьи <span class="text-danger">*</span></label>
            <div id="editor" aria-label="Текст статьи"></div>
            <input type="hidden" name="content" id="content">
        </div>

        <button type="submit" class="btn btn-success px-5">Опубликовать</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Напишите текст статьи...',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['blockquote', 'code-block'],
            ['link'],
            ['clean']
        ]
    }
});

document.getElementById('articleForm').addEventListener('submit', function () {
    document.getElementById('content').value = quill.root.innerHTML;
});
</script>
</body>
</html>
