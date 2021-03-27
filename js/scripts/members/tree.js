/*=========================================================================================
	File Name: account-setting.js
	Description: Account setting.
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

var ajaxURLs = {
    'children': '/member/getMemberTree/',
    'parent': '/orgchart/parent/',
    'siblings': function(nodeData) {
        return '/orgchart/siblings/' + nodeData.id;
    },
    'families': function(nodeData) {
        return '/orgchart/families/' + nodeData.id;
    }
};

function initTree(mId) {
    let _url = '/member/getMemberTree'; //+ (mId ? '/' + mId : '');
    //$('#modal-backdrop').modal('show');

    $.ajaxSetup({
        type: "POST",
        //url: _url,
        headers: addAuthHeader()
    });

    $.ajax({
        type: 'post',
        url: _url,
        data: { 'id': mId }
    })
    .done(function( data ) {
        //$('#modal-backdrop').modal('hide');
        let result = sanitizeData(JSON.parse(data));

        _orChart = $('#chart-container').orgchart({
            'chartClass': mId,
            'data' : result,
            'nodeTemplate': nodeTemplate,
            'ajaxURL': ajaxURLs,
            'pan': true,
            //'zoom': true,
            //'createNode': createNode,
            //nodeMouseClick: onNodeClicked
        });

        _orChart.$chartContainer.on('touchmove', function(event) {
            event.preventDefault();
        });

        _orChart.$chartContainer.on('init.orgchart', function (e) {
            resetNodeClick();
        })
    });
}

function sanitizeData(result) {
    let data = result;

    return data;
}

var nodeTemplate = function (data) {
    let _html = '<div class="title">Kosong</div>\n' +
        '<div class="content">Belum ada downline</div>';

    if (data.name) {
        _html = '<div class="title" onclick="nodeClicked(this)">' + (data.name == '-' ? 'Kosong' : data.name) + '</div>\n' +
            '<div class="content" onclick="nodeClicked(this)">\n' +
            '<div>ID : ' + (data.code == '-' ? 'Kosong' : data.code) + '</div>\n' +
            (data.code != '-' ?
                '<div class="membericon" style="color: ' + (data.level_id == 2 ? '#FFA500; border: 2px solid #ffa500' : '#87CEEB') + ';"><i class="fa fa-user"></i></div>\n' +
                '<div class="membername">' + data.name + '</div>\n' +
                '<div class="memberid">ID : ' + data.code + '</div>\n' +
                '<div>P/S : ' + (data.bv ? data.bv : '') + '</div>\n' +
                '<div>TUPO : ' + (data.cpd ? data.cpd : '') + '</div>\n' +
                '<div>Poin : ' + (data.poin ? data.poin : '') + '</div>\n'
            :
            '<div class="membericon" style="border-color: #FFC0CB"><i class="fa fa-ban"></i></div><div class="membername">kosong</div>\n') +
            '</div>';
    }

    return _html;
};

var createNode = function ($node, data) {
    if ($node.is('.drill-down')) {
        var assoClass = data.className.match(/asso-\w+/)[0];
        var drillDownIcon = $('<i>', {
            'class': 'oci oci-arrow-circle-down drill-icon',
            'click': function() {
                $('#chart-container').find('.orgchart:visible').addClass('hidden');
                if (!$('#chart-container').find('.orgchart.' + assoClass).length) {
                    initTree(assoClass);
                } else {
                    $('#chart-container').find('.orgchart.' + assoClass).removeClass('hidden');
                }
            }
        });
        $node.append(drillDownIcon);
    } else if ($node.is('.drill-up')) {
        var assoClass = data.className.match(/asso-\w+/)[0];
        var drillUpIcon = $('<i>', {
            'class': 'oci oci-arrow-circle-up drill-icon',
            'click': function() {
                $('#chart-container').find('.orgchart:visible').addClass('hidden').end()
                    .find('.drill-down.' + assoClass).closest('.orgchart').removeClass('hidden');
            }
        });
        $node.append(drillUpIcon);
    }
};

$('.tampil-ringkas').click(function (e) {
    $(".tampil-detail").removeClass("btn-primary");
    $(this).addClass("btn-primary");
    $("#chart-container").addClass("minimize");
});

$('.tampil-detail').click(function (e) {
    $(".tampil-ringkas").removeClass("btn-primary");
    $(this).addClass("btn-primary");
    $("#chart-container").removeClass("minimize");
});
