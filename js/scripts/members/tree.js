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
        });

        _orChart.$chartContainer.on('load-children.orgchart', function (e, f) {
            cobaSaja(e, f);
        });
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
        _html = '<div class="title">' + (data.name == '-' ? 'Kosong' : data.name) + '</div>\n' +
            '<div class="content">\n' +
            '<div>ID : ' + (data.code == '-' ? 'Kosong' : data.code) + '</div>\n' +
            (data.code != '-' ?
                '<div class="membericon" style="color: ' + (data.level_id == 2 ? '#FFA500; border: 2px solid #ffa500' : '#87CEEB') + ';"><i class="fa fa-user"></i></div>\n' +
                '<div class="membername">' + data.name + '</div>\n' +
                '<div class="memberid">ID : ' + data.code + '</div>\n' +
                '<div>PIN : ' + (data.pin ? data.pin : '0') + '</div>\n' +
                '<div>P/S : ' + (data.bv ? data.bv : '') + '</div>\n' +
                '<div>TUPO : ' + (data.cpd ? data.cpd : '') + '</div>\n' +
                '<div>Poin : ' + (data.poin ? data.poin : '0') + '</div>\n' +
                '<div>Bonus Poin : ' + (data.point_bonus ? data.point_bonus : '0') + '</div>\n' +
                '<div>Bonus Sponsor : ' + (data.sponsor_bonus ? data.sponsor_bonus : '0') + '</div>\n' +
                '<div>Bonus Pasangan : ' + (data.pair_bonus ? data.pair_bonus : '0') + '</div>\n'
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

function resetNodeClick() {
    $('div.node').unbind('click', 'nodeClickHandler');
    $('div.node').on('click', onNodeClicked.bind(this));

    $('div.node').each(function() {
        this.removeEventListener('mouseover', _orChart.nodeEnterLeaveHandler)
        $(this).unbind('mouseover', 'nodeEnterLeaveHandler');
    });
    $('div.node').each(function() {
        this.removeEventListener('mouseout', _orChart.nodeEnterLeaveHandler)
        $(this).unbind('mouseout', 'nodeEnterLeaveHandler');
    });

    //Munculkan panah samping dan bawah
    $('div.node').each(function(node) {
        addArrow($(this));
    });

    /*
    $('i.leftEdge').each(function (a) {
        if (!$(this).hasClass('oci-chevron-right'))
            $(this).addClass('oci-chevron-right');
    });
    $('i.rightEdge').each(function (a) {
        if (!$(this).hasClass('oci-chevron-left'))
            $(this).addClass('oci-chevron-left');
    });
    $('i.bottomEdge').each(function (a) {
        if (!$(this).hasClass('oci-chevron-up'))
            $(this).addClass('oci-chevron-up');
    });
    */
}

function nodeClicked(node, e) {
    //preventDefault();
    let _data = $($(node)[0].parentNode).data().nodeData;

    fillModal(_data);
    $('#modal-member').modal('show');
}
function onNodeClicked(node) {
    let _data = $(node.currentTarget).data().nodeData;
    //alert(JSON.stringify(_data));

    fillModal(_data);
    $('#modal-member').modal('show');
}

function fillModal(data) {
    $('#modal-member').find('.modal_name').html(': ' + data.name);
    $('#modal-member').find('.modal_code').html(': ' + data.code);
    $('#modal-member').find('.modal_pin').html(': ' + data.pin);
    $('#modal-member').find('.modal_bv').html(': ' + data.bv);
    $('#modal-member').find('.modal_cpd').html(': ' + data.cpd);
    $('#modal-member').find('.modal_point').html(': ' + data.poin);
}

$('.btn_export').click(function (e) {
    _orChart.export('STJ_Tree', 'png');
});

function addArrow($node) {
    var flag = false;
    if ($node.closest('.nodes.vertical').length) {
        var $toggleBtn = $node.children('.toggleBtn');
        //if (event.type === 'mouseenter') {
            if ($node.children('.toggleBtn').length) {
                flag = _orChart.getNodeState($node, 'children').visible;
                $toggleBtn.toggleClass('oci-plus-square', !flag).toggleClass('oci-minus-square', flag);
            }
        //} else {
        //    $toggleBtn.removeClass('oci-plus-square oci-minus-square');
        //}
    } else {
        var $topEdge = $node.children('.topEdge');
        var $rightEdge = $node.children('.rightEdge');
        var $bottomEdge = $node.children('.bottomEdge');
        var $leftEdge = $node.children('.leftEdge');
        //if (event.type === 'mouseenter') {
            if ($topEdge.length) {
                flag = _orChart.getNodeState($node, 'parent').visible;
                $topEdge.toggleClass('oci-chevron-up', !flag).toggleClass('oci-chevron-down', flag);
            }
            if ($bottomEdge.length) {
                flag = _orChart.getNodeState($node, 'children').visible;
                $bottomEdge.toggleClass('oci-chevron-down', !flag).toggleClass('oci-chevron-up', flag);
            }
            //if ($leftEdge.length) {
            //    _orChart.switchHorizontalArrow($node);
            //}
        //} else {
        //    $node.children('.edge').removeClass('oci-chevron-up oci-chevron-down oci-chevron-right oci-chevron-left');
        //}
    }
}
