<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><?= lang('playermap_title') ?></h4>
                </div>
                <div class="card-body p-0">
                    <?php if (count($realms) > 1): ?>
                    <div class="p-3 border-bottom">
                        <label for="realm-select"><?= lang('playermap_select_realm') ?>:</label>
                        <select id="realm-select" class="form-control" onchange="changeRealm(this.value)">
                            <?php foreach ($realms as $realm): ?>
                            <option value="<?= $realm->id ?>" <?= $realm->id == $realm_id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($realm->realm_name) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    <div id="playermap-container" style="position: relative; min-height: 800px; background: #000;">
                        <div id="loading" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #EABA28; font-size: 18px;">
                            <?= lang('playermap_loading') ?>
                        </div>
                        
                        <!-- Map layers -->
                        <div id="world" style="position: absolute; height: 732px; width: 966px; left: 50%; margin-left: -483px; background-image: url('<?= base_url('assets/img/map/azeroth.jpg') ?>'); z-index: 10;"></div>
                        <div id="outland" style="visibility: hidden; position: absolute; height: 732px; width: 966px; left: 50%; margin-left: -483px; background-image: url('<?= base_url('assets/img/map/outland.jpg') ?>'); z-index: 9;"></div>
                        <div id="northrend" style="visibility: hidden; position: absolute; height: 732px; width: 966px; left: 50%; margin-left: -483px; background-image: url('<?= base_url('assets/img/map/northrend.jpg') ?>'); z-index: 8;"></div>
                        
                        <!-- Points layers -->
                        <div id="pointsOldworld" style="position: absolute; height: 732px; width: 966px; left: 50%; margin-left: -483px; z-index: 100;"></div>
                        <div id="pointsOutland" style="visibility: hidden; position: absolute; height: 732px; width: 966px; left: 50%; margin-left: -483px; z-index: 99;"></div>
                        <div id="pointsNorthrend" style="visibility: hidden; position: absolute; height: 732px; width: 966px; left: 50%; margin-left: -483px; z-index: 98;"></div>
                        
                        <!-- Status window -->
                        <div id="serverstatus" style="<?= config_item('playermap_show_status') ? '' : 'display: none;' ?> position: absolute; height: 36px; width: 156px; margin-left: -78px; left: 50%; top: 97px; text-align: center; z-index: 101;">
                            <div id="status" style="font-family: verdana, arial, sans-serif; font-size: 12px; color: #EABA28; background-image: url('<?= base_url('assets/img/map/status.gif') ?>'); padding: 10px;"></div>
                        </div>
                        
                        <!-- Tooltip -->
                        <div id="tip" style="border: 0px solid #aaaaaa; left: -1000px; padding: 0px; position: absolute; top: -1000px; z-index: 150;"></div>
                        
                        <!-- Info bottom -->
                        <div id="info_bottom" style="position: absolute; height: 20px; width: 966px; left: 50%; margin-top: 711px; margin-left: -483px; z-index: 101; text-align: center;">
                            <div id="server_info" style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 20px; font-style: italic; font-weight: bold; color: #FFFF99;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#playermap-container {
    color: #EABA28;
    background-color: #000000;
}
.tip_header {
    background: #bb0000;
    font-weight: bold;
    color: #FFFFFF;
    font-family: arial, helvetica, sans-serif;
    font-size: 12px;
    text-align: center;
    padding: 3px;
}
.tip_head_text {
    background: rgb(50,50,50);
    font-weight: bold;
    color: #DDDD33;
    font-family: arial, helvetica, sans-serif;
    font-size: 12px;
    text-align: left;
    padding: 3px;
}
.tip_text {
    background: #000000;
    font-weight: normal;
    color: #ffffff;
    font-family: arial, helvetica, sans-serif;
    font-size: 12px;
    text-align: center;
    padding: 2px;
}
.tip_worldinfo {
    font-weight: normal;
    color: #FFFF99;
    font-family: Georgia, arial, helvetica, sans-serif;
    font-size: 12px;
    text-align: left;
    padding: 2px;
}
</style>

<script src="<?= base_url('assets/libs/js/JsHttpRequest/Js.js') ?>"></script>
<script>
var current_realm = <?= $realm_id ?>;
var current_map = 0;
var time = <?= config_item('playermap_time') ?? 5 ?>;
var show_time = <?= config_item('playermap_show_time') ? 'true' : 'false' ?>;
var show_status = <?= config_item('playermap_show_status') ? 'true' : 'false' ?>;
var maps_count = 3;
var maps_array = [0, 1, 530, 571, 609];
var maps_name_array = ['<?= lang('playermap_eastern_kingdoms') ?>', '<?= lang('playermap_outland') ?>', '<?= lang('playermap_northrend') ?>'];
var mpoints = [];
var pointx, pointy;

var race_name = {
    0: '', 1: 'Human', 2: 'Orc', 3: 'Dwarf', 4: 'Night Elf', 5: 'Undead',
    6: 'Tauren', 7: 'Gnome', 8: 'Troll', 10: 'Blood Elf', 11: 'Draenei'
};

var class_name = {
    0: '', 1: 'Warrior', 2: 'Paladin', 3: 'Hunter', 4: 'Rogue', 5: 'Priest',
    6: 'Death Knight', 7: 'Shaman', 8: 'Mage', 9: 'Warlock', 11: 'Druid'
};

var instances_x = [];
var instances_y = [];
instances_x[0] = { 2:0,13:0,17:0,30:762,33:712,34:732,35:732,36:712,37:0,43:245,44:0,47:238,48:172,70:833,90:738,109:849,129:254,150:0,169:0,189:773,209:269,229:782,230:778,249:290,269:315,289:816,309:782,329:834,349:123,369:745,389:308,409:783,429:164,449:741,450:305,451:0,469:778,489:244,509:160,529:820,531:144,532:798,534:317,560:320,568:897,572:750,580:868,585:883,595:322,618:313 };
instances_y[0] = { 2:0,13:0,17:0,30:278,33:295,34:511,35:503,36:567,37:0,43:419,44:0,47:508,48:291,70:443,90:419,109:551,129:516,150:0,169:0,189:216,209:568,229:481,230:484,249:514,269:601,289:258,309:589,329:203,349:432,369:497,389:352,409:484,429:496,449:508,450:352,451:0,469:480,489:364,509:607,529:321,531:603,532:569,534:596,560:606,568:172,572:245,580:26,585:16,595:601,618:348 };
instances_x[1] = { 540:593,542:586,543:593,544:588,545:393,546:399,547:388,548:399,550:683,552:680,553:672,554:669,555:495,556:506,557:495,558:483,559:408,562:443,564:740,565:485 };
instances_y[1] = { 540:399,542:398,543:405,544:402,545:355,546:350,547:353,548:357,550:226,552:215,553:210,554:239,555:569,556:557,557:545,558:557,559:489,562:239,564:567,565:204 };
instances_x[2] = { 533:568,574:749,575:751,576:161,578:159,599:553,600:605,601:395,602:575,603:559,604:740,608:470,615:491,616:155,617:457,619:400,624:363,631:400,632:415,649:475,650:465,658:393,668:410,724:491 };
instances_y[2] = { 533:456,574:577,575:583,576:443,578:451,599:195,600:406,601:462,602:180,603:169,604:292,608:360,615:465,616:447,617:352,619:462,624:369,631:350,632:350,649:207,650:207,658:362,668:365,724:455 };

function changeRealm(realm_id) {
    current_realm = realm_id;
    window.location.href = '<?= site_url('playermap?realm=') ?>' + realm_id;
}

function switchworld(n) {
    for(var i = 0; i < maps_count; i++) {
        var obj_map_layer = getMapLayerByID(i);
        var obj_points_layer = getPointsLayerByID(i);
        
        if(i == n) {
            obj_map_layer.style.visibility = "visible";
            obj_points_layer.style.visibility = "visible";
        } else {
            obj_map_layer.style.visibility = "hidden";
            obj_points_layer.style.visibility = "hidden";
        }
    }
}

function getMapLayerByID(id) {
    switch(id) {
        case 0: return document.getElementById("world");
        case 1: return document.getElementById("outland");
        case 2: return document.getElementById("northrend");
        default: return null;
    }
}

function getPointsLayerByID(id) {
    switch(id) {
        case 0: return document.getElementById("pointsOldworld");
        case 1: return document.getElementById("pointsOutland");
        case 2: return document.getElementById("pointsNorthrend");
        default: return null;
    }
}

function get_player_position(x, y, m) {
    var pos = {x: 0, y: 0};
    var where_530 = 0;
    x = Math.round(x);
    y = Math.round(y);
    
    if(m == 530) {
        if(y < -1000 && y > -10000 && x > 5000) {
            x = x - 10349; y = y + 6357; where_530 = 1;
        } else if(y < -7000 && x < 0) {
            x = x + 3961; y = y + 13931; where_530 = 2;
        } else {
            x = x - 3070; y = y - 1265; where_530 = 3;
        }
    } else if(m == 609) {
        x = x - 2355; y = y + 5662;
    }
    
    if(where_530 == 3) {
        var xpos = Math.round(x * 0.051446);
        var ypos = Math.round(y * 0.051446);
    } else if(m == 571) {
        var xpos = Math.round(x * 0.050085);
        var ypos = Math.round(y * 0.050085);
    } else {
        var xpos = Math.round(x * 0.025140);
        var ypos = Math.round(y * 0.025140);
    }
    
    // Convert map to string for comparison
    m = String(m);
    
    switch(m) {
        case '530':
            if(where_530 == 1) { pos.x = 858 - ypos; pos.y = 84 - xpos; }
            else if(where_530 == 2) { pos.x = 103 - ypos; pos.y = 261 - xpos; }
            else if(where_530 == 3) { pos.x = 684 - ypos; pos.y = 229 - xpos; }
            break;
        case '571':
            pos.x = 505 - ypos; pos.y = 642 - xpos;
            break;
        case '0':
            pos.x = 752 - ypos; pos.y = 291 - xpos;
            break;
        case '1':
            pos.x = 194 - ypos; pos.y = 398 - xpos;
            break;
        default:
            pos.x = 194 - ypos; pos.y = 398 - xpos;
    }
    return pos;
}

function in_array(value, arr) {
    for(var i = 0; i < arr.length; i++) {
        if(value == arr[i]) return true;
    }
    return false;
}

function show(data) {
    console.log('show() called with data:', data);
    
    if(!data) {
        for(var i = 0; i < maps_count; i++) {
            getPointsLayerByID(i).innerHTML = '';
        }
        document.getElementById("server_info").innerHTML = '';
        return;
    }
    
    mpoints = [];
    var instances = [];
    var groups = [];
    var single = [];
    var alliance_count = [];
    var horde_count = [];
    
    for(var i = 0; i < maps_count; i++) {
        instances[i] = '';
        groups[i] = '';
        single[i] = '';
        alliance_count[i] = data[i][0];
        horde_count[i] = data[i][1];
    }
    
    console.log('Alliance counts:', alliance_count);
    console.log('Horde counts:', horde_count);
    
    var point_count = 0;
    var i = maps_count;
    
    while(i < data.length) {
        var faction = 0;
        var text_col = '#0096BE';
        
        if(data[i].race == 2 || data[i].race == 5 || data[i].race == 6 || data[i].race == 8 || data[i].race == 10) {
            faction = 1;
            text_col = '#D2321E';
        }
        
        var char = '<img src="<?= base_url('assets/img/c_icons/') ?>' + data[i].race + '-' + data[i].gender + '.gif" style="float:center" border=0 width=18 height=18>';
        
        var n = 0;
        if(in_array(data[i].map, maps_array)) {
            var pos = get_player_position(data[i].x, data[i].y, data[i].map);
            while(n != point_count) {
                if(data[i].map == mpoints[n].map_id && Math.sqrt(Math.pow(pos.x - mpoints[n].x, 2) + Math.pow(pos.y - mpoints[n].y, 2)) < 3) break;
                n++;
            }
        } else {
            while(n != point_count) {
                if(mpoints[n].map_id == data[i].map) break;
                n++;
            }
        }
        
        if(n == point_count) {
            mpoints[n] = {
                map_id: data[i].map,
                name: data[i].name,
                zone: data[i].zone,
                player: 1,
                Extention: data[i].Extention,
                faction: faction,
                x: in_array(data[i].map, maps_array) ? pos.x : 0,
                y: in_array(data[i].map, maps_array) ? pos.y : 0,
                single_text: in_array(data[i].map, maps_array) ? data[i].zone + '<br>' + data[i].level + ' lvl<br>' + char + '&nbsp;<img src="<?= base_url('assets/img/c_icons/') ?>' + data[i].cl + '.gif" style="float:center" border=0 width=18 height=18><br>' + race_name[data[i].race] + '<br/>' + class_name[data[i].cl] + '<br/>' : '',
                multi_text: {current: 0, next: 0, first_members: [], text: []},
                current_leaderGuid: data[i].leaderGuid
            };
            n = point_count;
            point_count++;
        } else {
            mpoints[n].player += 1;
            mpoints[n].single_text = '';
        }
        
        mpoints[n].multi_text.text[mpoints[n].player - 1] = '<td align="left" valign="middle">&nbsp;' + data[i].name + '</td><td>' + data[i].level + '</td><td align="left">' + char + '</td><td align="left" style="color: ' + text_col + ';">&nbsp;' + race_name[data[i].race] + '</td><td align="left">&nbsp;<img src="<?= base_url('assets/img/c_icons/') ?>' + data[i].cl + '.gif" style="float:center" border=0 width=18 height=18></td><td align="left">&nbsp;' + class_name[data[i].cl] + '&nbsp;</td>';
        i++;
    }
    
    n = 0;
    while(n != point_count) {
        console.log('Processing point', n, ':', mpoints[n]);
        
        if(!in_array(mpoints[n].map_id, maps_array)) {
            console.log('Instance player:', mpoints[n].name, 'on map', mpoints[n].map_id);
            instances[mpoints[n].Extention] += '<img src="<?= base_url('assets/img/map/inst-icon.gif') ?>" style="position: absolute; border: 0px; left: ' + instances_x[mpoints[n].Extention][mpoints[n].map_id] + 'px; top: ' + instances_y[mpoints[n].Extention][mpoints[n].map_id] + 'px;">';
        } else if(mpoints[n].player > 1) {
            console.log('Group at:', mpoints[n].x, mpoints[n].y, 'Extension:', mpoints[n].Extention);
            groups[mpoints[n].Extention] += '<img src="<?= base_url('assets/img/map/group-icon.gif') ?>" style="position: absolute; border: 0px; left: ' + mpoints[n].x + 'px; top: ' + mpoints[n].y + 'px;">';
        } else {
            console.log('Single player:', mpoints[n].name, 'at', mpoints[n].x, mpoints[n].y, 'Extension:', mpoints[n].Extention, 'Faction:', mpoints[n].faction);
            var point = mpoints[n].faction ? "<?= base_url('assets/img/map/horde.gif') ?>" : "<?= base_url('assets/img/map/allia.gif') ?>";
            single[mpoints[n].Extention] += '<img src="' + point + '" style="position: absolute; border: 0px; left: ' + mpoints[n].x + 'px; top: ' + mpoints[n].y + 'px;">';
        }
        n++;
    }
    
    console.log('Single players HTML:', single);
    console.log('Groups HTML:', groups);
    console.log('Instances HTML:', instances);
    
    var players_count = [];
    var total_players_count = [0, 0];
    
    for(i = 0; i < maps_count; i++) {
        var obj = getPointsLayerByID(i);
        obj.innerHTML = instances[i] + single[i] + groups[i];
        players_count[i] = alliance_count[i] + horde_count[i];
        total_players_count[0] += alliance_count[i];
        total_players_count[1] += horde_count[i];
    }
    
    var info_html = '<?= lang('playermap_online') ?>: <b style="color: rgb(100,100,100);"><?= lang('playermap_total') ?></b> ' + (total_players_count[0] + total_players_count[1]);
    for(i = 0; i < maps_count; i++) {
        info_html += '&nbsp;<b style="color: rgb(160,160,20); cursor:pointer;" onClick="switchworld(' + i + ');">' + maps_name_array[i] + '</b> ' + players_count[i];
    }
    document.getElementById("server_info").innerHTML = info_html;
    document.getElementById("loading").style.display = 'none';
}

function load_data() {
    fetch('<?= site_url('playermap/get_players') ?>?realm=' + current_realm)
        .then(response => response.json())
        .then(data => {
            if(data.error) {
                console.error('Error:', data.error);
                document.getElementById("loading").innerHTML = '<?= lang('playermap_error') ?>';
                return;
            }
            show(data.online);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById("loading").innerHTML = '<?= lang('playermap_error') ?>';
        });
}

document.addEventListener('DOMContentLoaded', function() {
    load_data();
    if(time > 0) {
        setInterval(load_data, time * 1000);
    }
});
</script>
