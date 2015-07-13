<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $pismo['title'] ?></title>
    <style>
        html, body {
            background-color: #ffffff;
        }

        #editor-cont {
            width: 810px;
            background-color: #ffffff;
            float: left;
            margin-bottom: 20px;
            margin-top: 0;
            padding: 30px 50px 80px;
            position: relative;
            color: #333;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.42857;
        }

        #editor-cont .editor-controls {
            float: left;
            width: 100%;
        }

        #editor-cont .editor-controls .control {
            float: left;
            margin-bottom: 10px;
            margin-top: 10px;
            width: 100%;
        }

        #editor-cont .editor-controls .control p {
            margin: 0;
            padding: 0 5px;
        }

        #editor-cont .editor-controls .control.control-date {
            float: right;
            width: 50%;
            text-align: right;
        }

        #editor-cont .editor-controls .control.control-sender {
            margin-left: -10px;
            text-align: left;
            width: 50%;
        }

        #editor-cont .editor-controls .control.control-addressee {
            font-weight: bold;
            margin-left: 65%;
            text-align: left;
            width: 35%;
        }

        #editor-cont .editor-controls .control.control-template {
            float: left;
            font-size: 18px;
            font-weight: 400;
            margin-top: 60px;
            text-align: center;
            width: 100%;
        }

        #editor-cont .editor-controls .control.control-signature {
            text-align: left;
            margin-left: 65%;
            width: 35%;
            margin-right: -10px;
        }

        #editor {
            float: left;
            height: 100%;
            line-height: 1.5em;
            min-height: 300px;
            outline: medium none;
            padding: 10px;
            width: 100%;
            display: block;
        }

        #editor ul,
        #editor ol {
            margin-bottom: 10px;
            margin-top: 0;
            list-style: disc outside;
        }

        #editor blockquote {
            font-size: 14px;
        }

        #editor p {
            line-height: 1.5em;
            margin: 0 0 15px;
        }

        #editor .slownie ._slownie {
            color: #999;
        }

        #editor h1,
        #editor h2,
        #editor h3,
        #editor h4,
        #editor h5,
        #editor h6,
        #editor .h1,
        #editor .h2,
        #editor .h3,
        #editor .h4,
        #editor .h5,
        #editor .h6 {
            color: inherit;
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
        }

        #editor h1 small,
        #editor h2 small,
        #editor h3 small,
        #editor h4 small,
        #editor h5 small,
        #editor h6 small,
        #editor .h1 small,
        #editor .h2 small,
        #editor .h3 small,
        #editor .h4 small,
        #editor .h5 small,
        #editor .h6 small,
        #editor h1 .small,
        #editor h2 .small,
        #editor h3 .small,
        #editor h4 .small,
        #editor h5 .small,
        #editor h6 .small,
        #editor .h1 .small,
        #editor .h2 .small,
        #editor .h3 .small,
        #editor .h4 .small,
        #editor .h5 .small,
        #editor .h6 .small {
            color: #999;
            font-weight: 400;
            line-height: 1;
        }

        #editor h1,
        #editor .h1,
        #editor h2,
        #editor .h2,
        #editor h3,
        #editor .h3 {
            margin-bottom: 10px;
            margin-top: 20px;
        }

        #editor h1 small,
        #editor .h1 small,
        #editor h2 small,
        #editor .h2 small,
        #editor h3 small,
        #editor .h3 small,
        #editor h1 .small,
        #editor .h1 .small,
        #editor h2 .small,
        #editor .h2 .small,
        #editor h3 .small,
        #editor .h3 .small {
            font-size: 65%;
        }

        #editor h4,
        #editor .h4,
        #editor h5,
        #editor .h5,
        #editor h6,
        #editor .h6 {
            margin-bottom: 10px;
            margin-top: 10px;
        }

        #editor h4 small,
        #editor .h4 small,
        #editor h5 small,
        #editor .h5 small,
        #editor h6 small,
        #editor .h6 small,
        #editor h4 .small,
        #editor .h4 .small,
        #editor h5 .small,
        #editor .h5 .small,
        #editor h6 .small,
        #editor .h6 .small {
            font-size: 75%;
        }

        #editor h1,
        #editor .h1 {
            font-size: 36px;
            font-weight: bold;
        }

        #editor h2,
        #editor .h2 {
            font-size: 18px;
            font-weight: 400;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
        }

        #editor h3,
        #editor .h3 {
            font-size: 24px;
        }

        #editor h4,
        #editor .h4 {
            font-size: 18px;
        }

        #editor h5,
        #editor .h5 {
            font-size: 14px;
        }

        #editor h6,
        #editor .h6 {
            font-size: 12px;
        }
    </style>
</head>
<body>
<div id="editor-cont">
    <div class="editor-controls">
        <div class="control control-date">
            <?php if (!empty($pismo['data_pisma'])) {
                $months = array('stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia');
                $data_proc = explode('-', $pismo['data_pisma']);
                $data_slownie = $data_proc[2] . ' ' . $months[$data_proc[1] - 1] . ' ' . $data_proc[0];

                echo $data_slownie;
            } ?>
        </div>

        <div class="control control-sender">
            <?php if (!empty($pismo['nadawca'])) { ?>
                <div class="pre"><?= str_replace("\n", '<br/>', $pismo['nadawca']) ?></div>
            <? } ?>
        </div>

        <div class="control control-addressee">
            <?php if (!empty($pismo['adresat'])) {
                echo $pismo['adresat'];
            } ?>
        </div>

        <div class="control control-template">
            <?php if (!empty($pismo['tytul'])) {
                echo $pismo['tytul'];
            } ?>
        </div>
    </div>

    <article id="editor">
        <? if (!empty($pismo['tresc'])) {
            echo $pismo['tresc'];
        } ?>
    </article>

    <div class="editor-controls">
        <div class="control control-signature">
            <?php if (!empty($pismo['podpis'])) { ?>
                <div class="pre"><?= str_replace("\n", '<br/>', $pismo['podpis']) ?></div>
            <? } ?>
        </div>
    </div>
</div>
</body>
</html>