<div class="row">
    <div class="col-md-12 pismoTitle">

        <div class="titleBlock">
            <h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                <a href="/pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>"><?= $pismo['nazwa'] ?></a>
                <i class="glyphicon glyphicon-edit"></i>
            </h1>

            <div class="input-group hide">
                <input type="text" class="form-control" name="pismoTitleInput" value="<?= $pismo['nazwa'] ?>">

                <div class="input-group-btn">
                    <button class="btn btn-primary save" type="button">Zapisz</button>
                    <button class="btn btn-default cancel" type="button">Anuluj</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="letter-meta">
                    <p>Autor:
                        <b><? echo ($pismo['from_user_type'] == 'account') ? $pismo['from_user_name'] : "Anonimowy użytkownik" ?></b>
                    </p>

                    <p class="small"><b>Przed wysłaniem pisma należy je zapisać</b></p>
                </div>
            </div>
        </div>

    </div>
</div>
