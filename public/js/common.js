//タブ切り替え
$(function() {
    $('.nav-tab > li').on('click', function() {
        $('.nav-tab > li').removeClass('active')
        $(this).addClass('active')

        var index = $('.nav-tab > li').index(this);
        $('#contents > div').removeClass('show');
        $('#contents > div').eq(index).addClass('show');
    });
});

//タブ切り替え
$(function() {
    $('.nav-tab2 > li').on('click', function() {
        $('.nav-tab2 > li').removeClass('active2')
        $(this).addClass('active2')

        var index = $('.nav-tab2 > li').index(this);
        $('#contents2 > div').removeClass('show2');
        $('#contents2 > div').eq(index).addClass('show2');
    });
});
//TABLE LINK

$(function() {
    $('tbody tr[data-href]').addClass('clickable').click(function() {
        window.location = $(this).attr('data-href');
    }).find('a').hover(function() {
        $(this).parents('tr').unbind('click');
    }, function() {
        $(this).parents('tr').click(function() {
            window.location = $(this).attr('data-href');
        });
    });
});

//face






//チェックしたらボタンを押せるように
$(function() {
    $('#submit').attr('disabled', 'disabled');
    $('#submit').css({
        opacity: "0.5",
        cursor: "default"
    });

    $('#check').click(function() {
        if ($(this).prop('checked') == false) {
            $('#submit').attr('disabled', 'disabled');
            $('#submit').css({
                opacity: "0.5",
                cursor: "default"
            });

        } else {
            $('#submit').removeAttr('disabled');
            $('#submit').css({
                opacity: "1",
                cursor: "pointer"
            });
        }
    });
    $('.back').click(function() {
        $('#submit').attr('disabled', 'disabled');

    });
});
//受付完了
$(function() {
    $('.getjob').click(function() {
        alert('受付が完了しました');
    });
});

//受付完了
$(function() {
    $('.finish').click(function() {
        alert('登録が完了しました');
    });
});
//顔写真
$(function() {
    $("#file").on('change', function() {
        var file = $(this).prop('files')[0];
        if (!($(".filename").length)) {
            $("#file_input").append('<span class="filename"></span>');
        }
        $("#file_label").addClass('changed');
        $(".filename").html(file.name);
    });
});
//NEWS TAGS
$(function() {
    $(".search-navi span").click(function() {
        var tags = $(this).attr('id');
        $(".search-navi span").removeClass('select');
        $(this).addClass('select');
        $("#news-article article").hide();
        if (tags == 'type-a') {
            $("#news-article article.type-a").show();
        } else if (tags == 'type-b') {
            $("#news-article article.type-b").show();
        } else if (tags == 'type-c') {
            $("#news-article article.type-c").show();
        } else if (tags == 'type-d') {
            $("#news-article article.type-d").show();
        } else if (tags == 'type-e') {
            $("#news-article article.type-e").show();
        } else if (tags == 'type-f') {
            $("#news-article article.type-f").show();
        } else {
            $("#news-article article").show();
        }
    });
});
//文字数カット
$(function() {
    var $setElm = $('ul.qa-list li.slugtitle');
    var cutFigure = '18'; // カットする文字数
    var afterTxt = ' ...'; // 文字カット後に表示するテキスト

    $setElm.each(function() {
        var textLength = $(this).text().length;
        var textTrim = $(this).text().substr(0, (cutFigure))

        if (cutFigure < textLength) {
            $(this).html(textTrim + afterTxt).css({ visibility: 'visible' });
        } else if (cutFigure >= textLength) {
            $(this).css({ visibility: 'visible' });
        }
    });
});
//文字数カット
$(function() {
    var $setElm = $('h1.maintitle');
    var cutFigure = '18'; // カットする文字数
    var afterTxt = ' ...'; // 文字カット後に表示するテキスト

    $setElm.each(function() {
        var textLength = $(this).text().length;
        var textTrim = $(this).text().substr(0, (cutFigure))

        if (cutFigure < textLength) {
            $(this).html(textTrim + afterTxt).css({ visibility: 'visible' });
        } else if (cutFigure >= textLength) {
            $(this).css({ visibility: 'visible' });
        }
    });
});
//文字数カット
$(function() {
    var $setElm = $('.talk-people-message');
    var cutFigure = '20'; // カットする文字数
    var afterTxt = ' ...'; // 文字カット後に表示するテキスト

    $setElm.each(function() {
        var textLength = $(this).text().length;
        var textTrim = $(this).text().substr(0, (cutFigure))

        if (cutFigure < textLength) {
            $(this).html(textTrim + afterTxt).css({ visibility: 'visible' });
        } else if (cutFigure >= textLength) {
            $(this).css({ visibility: 'visible' });
        }
    });
});


//検索
$(function() {
    searchWord = function() {
        var searchResult,
            searchText = $(this).val(), // 検索ボックスに入力された値
            targetText,
            hitNum;

        // 検索結果を格納するための配列を用意
        searchResult = [];

        // 検索結果エリアの表示を空にする
        $('#search-result__list').empty();
        $('.search-result__hit-num').empty();

        // 検索ボックスに値が入ってる場合
        if (searchText != '') {
            $('#news-article article').each(function() {
                targetText = $(this).text();

                // 検索対象となるリストに入力された文字列が存在するかどうかを判断
                if (targetText.indexOf(searchText) != -1) {
                    // 存在する場合はそのリストのテキストを用意した配列に格納
                    searchResult.push(targetText);
                }
            });

            // 検索結果をページに出力
            for (var i = 0; i < searchResult.length; i++) {
                $('<span>').text(searchResult[i]).appendTo('#search-result__list');
            }

            // ヒットの件数をページに出力
            hitNum = '<span>検索結果</span>：' + searchResult.length + '件見つかりました。';
            $('.search-result__hit-num').append(hitNum);
        }
    };

    // searchWordの実行
    $('#search-text').on('input', searchWord);
});

$(function() {
    var flg = "off";
    $('li.bookmark2 a').on('click', function() {
        if (flg == "off") {
            $(this).text("ブックマークから削除");
            $(this).addClass("nagative");
            flg = "on";
        } else {
            $(this).text("ブックマークに追加");
            flg = "off";
        }
    });
})

$(function() {
    $('.menu-trigger').on('click', function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('main').removeClass('open');
            $('nav').removeClass('open');
            $('.overlay').removeClass('open');
        } else {
            $(this).addClass('active');
            $('main').addClass('open');
            $('nav').addClass('open');
            $('.overlay').addClass('open');
        }
    });
    $('.overlay').on('click', function() {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $('.menu-trigger').removeClass('active');
            $('main').removeClass('open');
            $('nav').removeClass('open');
        }
    });
});

$(function() {
    $('ul#gnav li a').each(function() {
        var url = $(this).attr('href');
        if (location.href.match(url)) {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
    });
});

$(function() {
    $('.second-question').hide();
    $('.next').on('click', function() {
        $('.first-question').fadeOut();
        setTimeout(function() {
            $('.second-question').fadeIn();
        }, 800);
    });
    $('.back').on('click', function() {
        $('.second-question').fadeOut();
        setTimeout(function() {
            $('.first-question').fadeIn();
        }, 800);
    });
});

$(function() {
    // 初期状態のボタンは無効
    $(".next").addClass('opa2')
    $(".next").prop("disabled", true);
    // チェックボックスの状態が変わったら（クリックされたら）
    $(".first-question input[type='checkbox']").on('change', function() {
        // チェックされているチェックボックスの数
        if ($(".first-question input[type='checkbox']:checked").length > 4) {
            // ボタン有効
            $(".next").prop("disabled", false);
            $(".next").removeClass('opa2')
        } else {
            // ボタン無効
            $(".next").prop("disabled", true);
            $(".next").addClass('opa2')
        }
    });
    // 初期状態のボタンは無効
    $(".submit").addClass('opa2')
    $(".submit").prop("disabled", true);
    // チェックボックスの状態が変わったら（クリックされたら）
    $(".second-question input[type='checkbox']").on('change', function() {
        // チェックされているチェックボックスの数
        if ($(".second-question input[type='checkbox']:checked").length > 1) {
            // ボタン有効
            $(".submit").prop("disabled", false);
            $(".submit").removeClass('opa2')
        } else {
            // ボタン無効
            $(".submit").prop("disabled", true);
            $(".submit").addClass('opa2')
        }
    });
});

$(function() {

    /*-------------------------------
    カウントアップ
    -------------------------------*/
    /* 初期値の設定 */
    var priceBase = removeFigure($(".basePrice1").text()); //基本価格を取得
    var priceOptions = removeFigure($(".optionTotal").text()); //オプション合計を取得
    var priceTotal = priceBase + priceOptions; //基本価格とオプション合計から総額を計算
    var optionsPrice = 0; //加算するオプション価格の初期設定
    var basePrice = priceBase; //数量変更後の基本価格を変更

    $(".priceTotal").text(addFigure(priceTotal)); //総額を反映

    $(".options1 :checkbox").click(function() {
        optionsPrice = 0; //加算するオプション価格を初期化
        $(".options1 :checkbox:checked").each(function() {
            //指定された範囲の中にある、すべてのチェックされたチェックボックスと同じラベル内にある、.optionPriceのテキストを取得
            optionsPrice = optionsPrice + removeFigure($(this).parent("label").find(".optionPrice").text());
        });
        var timerPrice = setInterval(function() {
            if (priceOptions != optionsPrice) { //計算前と計算後の値が同じになるまで実行する
                if (priceOptions < optionsPrice) { //元の数が計算後の数より大きいか小さいかを判定
                    priceOptions = priceOptions + Math.round((optionsPrice - priceOptions) / 2); //値を反比例して加減する
                } else {
                    priceOptions = priceOptions - Math.round((priceOptions - optionsPrice) / 2);
                }

                //算出されたオプション合計と総額をHTMLに反映
                $(".optionTotal1").text(addFigure(priceOptions));
                $(".total1").text(addFigure(priceBase + priceOptions));
            } else {
                clearInterval(timerPrice);
            }
        }, 17);
    });

    $("select.num").change(function() {
        //セレクトボックス内の選択されているoptionのdata-price属性を取得
        basePrice = removeFigure($(this).find("option:selected").attr("data-price"));

        var timerPrice = setInterval(function() {
            if (priceBase != basePrice) {
                if (priceBase < basePrice) {
                    priceBase = priceBase + Math.round((basePrice - priceBase) / 2);
                } else {
                    priceBase = priceBase - Math.round((priceBase - basePrice) / 2);
                }

                //算出された基本価格と総額をHTMLに反映
                $(".basePrice1").text(addFigure(priceBase + priceOptions));
                $(".total1").text(addFigure(priceBase + priceOptions));
            } else {
                clearInterval(timerPrice);
            }

        }, 17);
    });




    /*-------------------------------
    カンマ処理
    -------------------------------*/
    function addFigure(str) {
        var num = new String(str).replace(/,/g, "");
        while (num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
        return num;
    }

    function removeFigure(str) {
        var num = new String(str).replace(/,/g, "");
        num = Number(num);
        return num;
    }

});


$(function() {
    $('input.add').click(function() {
        alert('追加しました');
        $(this).fadeOut();
        return false;
    })
});

//アコーディオン
$(function() {
    $('.goods-box dt').click(function() {
        $(this).next().slideToggle();
        $(this).toggleClass('on');
    });
});