<?php
	require_once('classes/global.php');
    ob_start();
	    include_once 'include.php';
    ob_end_clean();
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>OsTECH Sermon Editor</title>
    <link href="https://code.jquery.com/ui/1.12.1/themes/redmond/jquery-ui.css" rel="stylesheet" />
    <script src="https://cdn.tiny.cloud/1/dget7v4hw3em64lyrruk9n2j4xb3dwzstntecb4y1wokj0z8/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        body{
            width:800px;
            margin:0 auto;
        }
        .expand {
            font-weight: bold;
            font-style: italic;
            font-size: 12px;
            cursor: pointer;
        }
        .expandable {
            display: none;
        }
    </style>
</head>
<body>
    <div id="wait" style="display:none; background-color: #A9A9A9; opacity:.8; width:100%; height:140%; position:absolute; left:0px; top:0px; z-index:999;"><img style="left:50%; top:40%; position:absolute;" src="images/ajax-loader.gif"></div>
    <select id="selTags" style="width:175px;">
        <option value="acknowledging">Acknowledging</option>
        <option value="addiction">Addiction</option>
        <option value="almighty">Almighty</option>
        <option value="angels">Angels</option>
        <option value="anger">Anger</option>
        <option value="ascension">Ascension</option>
        <option value="awe">Awe</option>
        <option value="baptism">Baptism</option>
        <option value="beauty">Beauty</option>
        <option value="blameless">Blameless</option>
        <option value="blessing">Blessing</option>
        <option value="blood">Blood</option>
        <option value="body">Body</option>
        <option value="bread">Bread</option>
        <option value="calling">Calling</option>
        <option value="children">Children</option>
        <option value="christmas">Christmas</option>
        <option value="church">Church</option>
        <option value="clothing">Clothing</option>
        <option value="comforter">Comforter</option>
        <option value="community">Community</option>
        <option value="compassion">Compassion</option>
        <option value="confession">Confession</option>
        <option value="contentment">Contentment</option>
        <option value="conversion">Conversion</option>
        <option value="courage">Courage</option>
        <option value="covenant">Covenant</option>
        <option value="creation">Creation</option>
        <option value="crucifixion">Crucifixion</option>
        <option value="death">Death</option>
        <option value="debt">Debt</option>
        <option value="dependence">Dependence</option>
        <option value="desires">Desires</option>
        <option value="devil">Devil</option>
        <option value="easter">Easter</option>
        <option value="encouragement">Encouragement</option>
        <option value="equipment">Equipment</option>
        <option value="eternal-life">Eternal-life</option>
        <option value="evangelism">Evangelism</option>
        <option value="evil">Evil</option>
        <option value="faith">Faith</option>
        <option value="faithfulness">Faithfulness</option>
        <option value="family">Family</option>
        <option value="fasting">Fasting</option>
        <option value="father">Father</option>
        <option value="fear">Fear</option>
        <option value="following">Following</option>
        <option value="food">Food</option>
        <option value="forgiveness">Forgiveness</option>
        <option value="freedom">Freedom</option>
        <option value="friendship">Friendship</option>
        <option value="fruitfulness">Fruitfulness</option>
        <option value="generosity">Generosity</option>
        <option value="gentleness">Gentleness</option>
        <option value="giving">Giving</option>
        <option value="god">God</option>
        <option value="goodness">Goodness</option>
        <option value="gossip">Gossip</option>
        <option value="grace">Grace</option>
        <option value="gratitude">Gratitude</option>
        <option value="greed">Greed</option>
        <option value="harvest">Harvest</option>
        <option value="healing">Healing</option>
        <option value="health">Health</option>
        <option value="heart">Heart</option>
        <option value="heaven">Heaven</option>
        <option value="hell">Hell</option>
        <option value="holiness">Holiness</option>
        <option value="holy-spirit">Holy-Spirit</option>
        <option value="honesty">Honesty</option>
        <option value="hope">Hope</option>
        <option value="humility">Humility</option>
        <option value="idols">Idols</option>
        <option value="jesus">Jesus</option>
        <option value="joy">Joy</option>
        <option value="judgment">Judgment</option>
        <option value="kingdom">Kingdom</option>
        <option value="law">Law</option>
        <option value="learning">Learning</option>
        <option value="life">Life</option>
        <option value="light">Light</option>
        <option value="listening">Listening</option>
        <option value="love">Love</option>
        <option value="lying">Lying</option>
        <option value="marriage">Marriage</option>
        <option value="materialism">Materialism</option>
        <option value="mediator">Mediator</option>
        <option value="mercy">Mercy</option>
        <option value="messiah">Messiah</option>
        <option value="mind">Mind</option>
        <option value="miracles">Miracles</option>
        <option value="money">Money</option>
        <option value="nearness">Nearness</option>
        <option value="neighbor">Neighbor</option>
        <option value="obedience">Obedience</option>
        <option value="orphans">Orphans</option>
        <option value="overcoming">Overcoming</option>
        <option value="patience">Patience</option>
        <option value="peace">Peace</option>
        <option value="pentecost">Pentecost</option>
        <option value="persecution">Persecution</option>
        <option value="planning">Planning</option>
        <option value="poverty">Poverty</option>
        <option value="praise">Praise</option>
        <option value="prayer">Prayer</option>
        <option value="pride">Pride</option>
        <option value="promises">Promises</option>
        <option value="prophecy">Prophecy</option>
        <option value="protection">Protection</option>
        <option value="punishment">Punishment</option>
        <option value="purification">Purification</option>
        <option value="rebirth">Rebirth</option>
        <option value="receiving">Receiving</option>
        <option value="reconciliation">Reconciliation</option>
        <option value="redeemer">Redeemer</option>
        <option value="relationships">Relationships</option>
        <option value="reliability">Reliability</option>
        <option value="repentance">Repentance</option>
        <option value="rest">Rest</option>
        <option value="resurrection">Resurrection</option>
        <option value="reward">Reward</option>
        <option value="righteousness">Righteousness</option>
        <option value="sabbath">Sabbath</option>
        <option value="sacrifice">Sacrifice</option>
        <option value="sadness">Sadness</option>
        <option value="safety">Safety</option>
        <option value="salvation">Salvation</option>
        <option value="savior">Savior</option>
        <option value="second-coming">Second-coming</option>
        <option value="seeking">Seeking</option>
        <option value="self-control">Self-control</option>
        <option value="selfishness">Selfishness</option>
        <option value="serving">Serving</option>
        <option value="sickness">Sickness</option>
        <option value="sin">Sin</option>
        <option value="singing">Singing</option>
        <option value="slavery">Slavery</option>
        <option value="soul">Soul</option>
        <option value="speaking">Speaking</option>
        <option value="spirit">Spirit</option>
        <option value="strength">Strength</option>
        <option value="suffering">Suffering</option>
        <option value="temptation">Temptation</option>
        <option value="thoughts">Thoughts</option>
        <option value="transformation">Transformation</option>
        <option value="trust">Trust</option>
        <option value="truth">Truth</option>
        <option value="understanding">Understanding</option>
        <option value="valuable">Valuable</option>
        <option value="weakness">Weakness</option>
        <option value="widows">Widows</option>
        <option value="wine">Wine</option>
        <option value="wisdom">Wisdom</option>
        <option value="the-word">The-word</option>
        <option value="work">Work</option>
        <option value="world">World</option>
        <option value="worrying">Worrying</option>
        <option value="worship">Worship</option>
    </select>
    <button id="btnFilter" value="Filter" onclick="filterVerses()">Filter</button>
    <script type="text/javascript">
	    let refToken        = "<?php echo $CID ?>";
        let $acBibleVerses  = {};
        $(function () {
            $(document).ready(function () {
                tinymce.init({
                    selector: 'textarea',
                      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
                      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
                      toolbar_mode: 'floating',
                      tinycomments_mode: 'embedded',
                      tinycomments_author: 'Author name',
                });
                $('.ui-icon').click(function () {
                    if ($(this).hasClass("ui-icon-folder-collapsed")) {
                        $(this).removeClass("ui-icon-folder-collapsed");
                        $(this).addClass("ui-icon-folder-open");
                    } else {
                        $(this).removeClass("ui-icon-folder-open");
                        $(this).addClass("ui-icon-folder-collapsed");
                    }
                    $("#divResults").slideToggle('fast');
                });
                $.getJSON('Verses.json', function (data) {
                    $.each(data, function (i) {
                        $acBibleVerses[data[i]["id"]] = data[i];
                    })
                })
            })
        })
        function filterVerses() {
            var sTag = $("#selTags").val();
            if (!sTag) {
                alert("Need to select a topic");
                return;
            }
            var sHtml       = "";
			var objSearch   = { action: "getBibleVerses", Ttag : sTag, token: refToken };
			var _sDynURL    = 'ajaxCalls.php';
			$('#wait').show();
			$.post(_sDynURL, objSearch)
				.done(function (data) {
					$('#wait').hide();
					try {
						if (data.ERROR) {
							alert("ERROR in Server Occured " + data.ERROR);
							return;
						}
						$.each(data, function (i, item) {
                            sHtml += "<span style=\"pointer:arrow\" class=\"ui-icon ui-icon-copy\"></span><li><b>" + item.verse + "</b><br />" + item.scripture + "</li>";
						});
					}
					catch (e) {
						alert("Client Error " + e + "\n" + JSON.stringify(data));
					}
			    })
			    .fail(function (xhr, textStatus, errorThrown) {
				    alert("Failed " + xhr.responseText);
				    $('#wait').hide();
			    })
			    .always(function () {
                    $('#wait').hide();
                    $("#divResults").html(sHtml);
                    $('#divResults .ui-icon-copy').click(function () {
                        var $ne = $(this).next();
                        tinymce.activeEditor.execCommand('mceInsertContent', false, $ne[0].innerHTML);
                    });
			    });
            $("#expand-1").removeClass("ui-icon-folder-collapsed");
            $("#expand-1").addClass("ui-icon-folder-open");
        }
    </script>
    <div id="otEdit">
        <textarea id="taLesson" style="height:250px; width:770px;">
        </textarea>
        <div style="padding-top:30px; padding-bottom:30px;">
           <span class="ui-icon ui-icon-folder-collapsed" id="expand-1">more 1...</span>
           <div class="expandable" id="divResults" style="display:block; min-block-size:120px; overflow:auto;"></div>
        </div>
    </div>
</body>
</html>