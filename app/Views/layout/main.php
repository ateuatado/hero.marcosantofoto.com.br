<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Marco Santo | Fotografia de Alta Performance') ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: EB Garamond + Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --mst-gold:      #C5A059;
            --mst-gold-dim:  rgba(197, 160, 89, 0.55);
            --mst-bg:        #000000;
        }

        body {
            background-color: var(--mst-bg);
            font-family: 'Inter', system-ui, sans-serif;
            font-weight: 300;
            color: #ffffff;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'EB Garamond', Georgia, serif;
            font-weight: 500;
            letter-spacing: 0.03em;
        }

        .text-gold { color: var(--mst-gold) !important; }

        .navbar { background-color: transparent !important; transition: background-color 0.3s ease; }
        .navbar.scrolled { background-color: rgba(0, 0, 0, 0.92) !important; backdrop-filter: blur(10px); }
        .navbar-brand { font-family: 'EB Garamond', serif; font-size: 1.1rem; color: var(--mst-gold) !important; }
        .navbar-brand .nav-sub { font-family: 'Inter', sans-serif; font-size: 0.65rem; font-weight: 400; letter-spacing: 0.18em; text-transform: uppercase; opacity: 0.5; margin-left: 8px; }
        .nav-link { font-family: 'Inter', sans-serif; font-size: 0.72rem; letter-spacing: 0.18em; text-transform: uppercase; }

        .btn-terroso {
            background-color: var(--mst-gold);
            border-color:     var(--mst-gold);
            color: #000;
            font-family: 'Inter', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }
        .btn-terroso:hover {
            background-color: #d4b06a;
            border-color:     #d4b06a;
            color: #000;
        }
        .btn-outline-terroso {
            border-color: var(--mst-gold);
            color: var(--mst-gold);
            font-family: 'Inter', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }
        .btn-outline-terroso:hover {
            background-color: var(--mst-gold);
            color: #000;
        }

        .hero-link { text-decoration: none; color: inherit; }
        a:hover .hero-card-img { transform: scale(1.05); }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url('/') ?>">
                Marco Santo <span class="nav-sub">Alta Performance</span>
            </a>
        </div>
    </nav>

    <?= $this->renderSection('content') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function () {
            document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 50);
        }, { passive: true });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
