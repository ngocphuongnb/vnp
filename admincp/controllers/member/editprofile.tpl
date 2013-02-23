<!-- BEGIN: main -->
<ul class="breadcrumb">
    <li><a href="#">Home</a><span class="divider">»</span></li>
    <li><a href="#">Library</a><span class="divider">»</span></li>
    <li class="active">Data</li>
</ul>
<div class="row-fluid">
    <div class="span7">
        <div class="nonboxy-widget">
            <div class="widget-head">
                <h5> Form Elements</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input01">Text input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge text-tip" id="input01" data-original-title="first tooltip">
                                    <p class="help-block">
                                         In addition to freeform text, any HTML5 text-based input appears like so.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="typehead">Auto Complete</label>
                                <div class="controls">
                                    <input type="text" class="span8" data-provide="typeahead" data-items="5" data-source="[&quot;Alabama&quot;,&quot;Alaska&quot;,&quot;Arizona&quot;,&quot;Arkansas&quot;,&quot;California&quot;,&quot;Colorado&quot;,&quot;Connecticut&quot;,&quot;Delaware&quot;,&quot;Florida&quot;,&quot;Georgia&quot;,&quot;Hawaii&quot;,&quot;Idaho&quot;,&quot;Illinois&quot;,&quot;Indiana&quot;,&quot;Iowa&quot;,&quot;Kansas&quot;,&quot;Kentucky&quot;,&quot;Louisiana&quot;,&quot;Maine&quot;,&quot;Maryland&quot;,&quot;Massachusetts&quot;,&quot;Michigan&quot;,&quot;Minnesota&quot;,&quot;Mississippi&quot;,&quot;Missouri&quot;,&quot;Montana&quot;,&quot;Nebraska&quot;,&quot;Nevada&quot;,&quot;New Hampshire&quot;,&quot;New Jersey&quot;,&quot;New Mexico&quot;,&quot;New York&quot;,&quot;North Dakota&quot;,&quot;North Carolina&quot;,&quot;Ohio&quot;,&quot;Oklahoma&quot;,&quot;Oregon&quot;,&quot;Pennsylvania&quot;,&quot;Rhode Island&quot;,&quot;South Carolina&quot;,&quot;South Dakota&quot;,&quot;Tennessee&quot;,&quot;Texas&quot;,&quot;Utah&quot;,&quot;Vermont&quot;,&quot;Virginia&quot;,&quot;Washington&quot;,&quot;West Virginia&quot;,&quot;Wisconsin&quot;,&quot;Wyoming&quot;]" id="typehead">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input02">Password Input</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" id="input02">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Uneditable input</label>
                                <div class="controls">
                                    <span class="input-xlarge uneditable-input">Some value here</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input04">Disable Input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge disabled" disabled="disabled" placeholder="Disabled input here…" id="input04">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" value="option1">
                                    Option one</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Disabled checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" disabled="" value="option1">
                                    This is a disabled checkbox </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Inline checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option1">
                                    1 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option2">
                                    2 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option3">
                                    3 </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" value="option1" name="optionsCheckboxList1">
                                    Option one</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option2" name="optionsCheckboxList2">
                                    Option two</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option3" name="optionsCheckboxList3">
                                    Option three</label>
                                    <p class="help-block">
                                        <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Radio buttons</label>
                                <div class="controls">
                                    <label class="radio">
                                    <input type="radio" checked="" value="option1" name="optionsRadios">
                                    Option one</label>
                                    <label class="radio">
                                    <input type="radio" value="option2" name="optionsRadios">
                                    Option two</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Select list</label>
                                <div class="controls">
                                    <select>
                                        <option>something</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Multicon-select</label>
                                <div class="controls">
                                    <select multiple="multiple">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">File input</label>
                                <div class="controls">
                                    <div class="uni-uploader" id="uniform-undefined"><input class="input-file" type="file" size="19" style="opacity: 0;"><span class="filename">No file selected</span><span class="action">Choose File</span></div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Textarea</label>
                                <div class="controls">
                                    <textarea class="input-xlarge" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-info">Save changes</button>
                                <button class="btn btn-warning">Cancel</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="span5">
        <div class="nonboxy-widget">
            <div class="widget-head">
                <h5> Left Label Uppercase</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input205">Text input</label>
                                <div class="controls">
                                    <input type="text" class="input-medium text-tip" id="input205" data-original-title="first tooltip">
                                    <p class="help-block">
                                         In addition to freeform text, any HTML5 text-based input appears like so.
                                    </p>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="widget-head">
                <h5>Top Label</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="well">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input101">Text input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge text-tip" id="input101" data-original-title="first tooltip">
                                    <p class="help-block">
                                         In addition to freeform text, any HTML5 text-based input appears like so.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input102">Password Input</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" id="input102">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Uneditable input</label>
                                <div class="controls">
                                    <span class="input-xlarge uneditable-input">Some value here</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input103">Disable Input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge disabled" disabled="disabled" placeholder="Disabled input here…" id="input103">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Disabled checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" disabled="" value="option1">
                                    This is a disabled checkbox </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Inline checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option1">
                                    1 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option2">
                                    2 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option3">
                                    3 </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" value="option1" name="optionsCheckboxList1">
                                    Option one</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option2" name="optionsCheckboxList2">
                                    Option two</label>
                                    <p class="help-block">
                                        <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
                                    </p>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="widget-head">
                <h5> Top Label Uppercase</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class=" well ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input201">Text input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge text-tip" id="input201" data-original-title="first tooltip">
                                    <p class="help-block">
                                         In addition to freeform text, any HTML5 text-based input appears like so.
                                    </p>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="widget-head">
                <h5> Inline Form</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="well form-inline">
                        <input type="text" class="input-small" placeholder="Email">
                        <input type="password" class="input-small" placeholder="Password">
                        <button type="submit" class="btn">Sign in</button>
                        <label class="checkbox">
                        <input type="checkbox">
                        Remember me </label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-header">
    <h1>Extended Form Elements <small>used some cool plugins</small></h1>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="nonboxy-widget">
            <div class="widget-head">
                <h5> Select Box</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input02">Multiplee Seletct</label>
                                <div class="controls">
                                    <select data-placeholder="Your Favorite Football Team" class="chzn-select chzn-done" multiple="" tabindex="-1" style="width: 300px; display: none;" id="sel6CS">
                                        <option value=""></option>
                                        <optgroup label="NFC EAST">
                                        <option>Dallas Cowboys</option>
                                        <option>New York Giants</option>
                                        <option>Philadelphia Eagles</option>
                                        <option>Washington Redskins</option>
                                        </optgroup>
                                        <optgroup label="NFC NORTH">
                                        <option>Chicago Bears</option>
                                        <option>Detroit Lions</option>
                                        <option>Green Bay Packers</option>
                                        <option>Minnesota Vikings</option>
                                        </optgroup>
                                        <optgroup label="NFC SOUTH">
                                        <option>Atlanta Falcons</option>
                                        <option>Carolina Panthers</option>
                                        <option>New Orleans Saints</option>
                                        <option>Tampa Bay Buccaneers</option>
                                        </optgroup>
                                        <optgroup label="NFC WEST">
                                        <option>Arizona Cardinals</option>
                                        <option>St. Louis Rams</option>
                                        <option>San Francisco 49ers</option>
                                        <option>Seattle Seahawks</option>
                                        </optgroup>
                                        <optgroup label="AFC EAST">
                                        <option>Buffalo Bills</option>
                                        <option>Miami Dolphins</option>
                                        <option>New England Patriots</option>
                                        <option>New York Jets</option>
                                        </optgroup>
                                        <optgroup label="AFC NORTH">
                                        <option>Baltimore Ravens</option>
                                        <option>Cincinnati Bengals</option>
                                        <option>Cleveland Browns</option>
                                        <option>Pittsburgh Steelers</option>
                                        </optgroup>
                                        <optgroup label="AFC SOUTH">
                                        <option>Houston Texans</option>
                                        <option>Indianapolis Colts</option>
                                        <option>Jacksonville Jaguars</option>
                                        <option>Tennessee Titans</option>
                                        </optgroup>
                                        <optgroup label="AFC WEST">
                                        <option>Denver Broncos</option>
                                        <option>Kansas City Chiefs</option>
                                        <option>Oakland Raiders</option>
                                        <option>San Diego Chargers</option>
                                        </optgroup>
                                    </select><div id="sel6CS_chzn" class="chzn-container chzn-container-multi" style="width: 300px;"><ul class="chzn-choices"><li class="search-field"><input type="text" value="Your Favorite Football Team" class="default" autocomplete="off" style="width: 178px;" tabindex="15"></li></ul><div class="chzn-drop" style="left: -9000px; width: 298px; top: 29px;"><ul class="chzn-results"><li id="sel6CS_chzn_g_1" class="group-result">NFC EAST</li><li id="sel6CS_chzn_o_2" class="active-result group-option" style="">Dallas Cowboys</li><li id="sel6CS_chzn_o_3" class="active-result group-option" style="">New York Giants</li><li id="sel6CS_chzn_o_4" class="active-result group-option" style="">Philadelphia Eagles</li><li id="sel6CS_chzn_o_5" class="active-result group-option" style="">Washington Redskins</li><li id="sel6CS_chzn_g_6" class="group-result">NFC NORTH</li><li id="sel6CS_chzn_o_7" class="active-result group-option" style="">Chicago Bears</li><li id="sel6CS_chzn_o_8" class="active-result group-option" style="">Detroit Lions</li><li id="sel6CS_chzn_o_9" class="active-result group-option" style="">Green Bay Packers</li><li id="sel6CS_chzn_o_10" class="active-result group-option" style="">Minnesota Vikings</li><li id="sel6CS_chzn_g_11" class="group-result">NFC SOUTH</li><li id="sel6CS_chzn_o_12" class="active-result group-option" style="">Atlanta Falcons</li><li id="sel6CS_chzn_o_13" class="active-result group-option" style="">Carolina Panthers</li><li id="sel6CS_chzn_o_14" class="active-result group-option" style="">New Orleans Saints</li><li id="sel6CS_chzn_o_15" class="active-result group-option" style="">Tampa Bay Buccaneers</li><li id="sel6CS_chzn_g_16" class="group-result">NFC WEST</li><li id="sel6CS_chzn_o_17" class="active-result group-option" style="">Arizona Cardinals</li><li id="sel6CS_chzn_o_18" class="active-result group-option" style="">St. Louis Rams</li><li id="sel6CS_chzn_o_19" class="active-result group-option" style="">San Francisco 49ers</li><li id="sel6CS_chzn_o_20" class="active-result group-option" style="">Seattle Seahawks</li><li id="sel6CS_chzn_g_21" class="group-result">AFC EAST</li><li id="sel6CS_chzn_o_22" class="active-result group-option" style="">Buffalo Bills</li><li id="sel6CS_chzn_o_23" class="active-result group-option" style="">Miami Dolphins</li><li id="sel6CS_chzn_o_24" class="active-result group-option" style="">New England Patriots</li><li id="sel6CS_chzn_o_25" class="active-result group-option" style="">New York Jets</li><li id="sel6CS_chzn_g_26" class="group-result">AFC NORTH</li><li id="sel6CS_chzn_o_27" class="active-result group-option" style="">Baltimore Ravens</li><li id="sel6CS_chzn_o_28" class="active-result group-option" style="">Cincinnati Bengals</li><li id="sel6CS_chzn_o_29" class="active-result group-option" style="">Cleveland Browns</li><li id="sel6CS_chzn_o_30" class="active-result group-option" style="">Pittsburgh Steelers</li><li id="sel6CS_chzn_g_31" class="group-result">AFC SOUTH</li><li id="sel6CS_chzn_o_32" class="active-result group-option" style="">Houston Texans</li><li id="sel6CS_chzn_o_33" class="active-result group-option" style="">Indianapolis Colts</li><li id="sel6CS_chzn_o_34" class="active-result group-option" style="">Jacksonville Jaguars</li><li id="sel6CS_chzn_o_35" class="active-result group-option" style="">Tennessee Titans</li><li id="sel6CS_chzn_g_36" class="group-result">AFC WEST</li><li id="sel6CS_chzn_o_37" class="active-result group-option" style="">Denver Broncos</li><li id="sel6CS_chzn_o_38" class="active-result group-option" style="">Kansas City Chiefs</li><li id="sel6CS_chzn_o_39" class="active-result group-option" style="">Oakland Raiders</li><li id="sel6CS_chzn_o_40" class="active-result group-option" style="">San Diego Chargers</li></ul></div></div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Select</label>
                                <div class="controls">
                                    <select data-placeholder="Your Favorite Football Team" style="width: 300px; display: none;" class="chzn-select chzn-done" tabindex="-1" id="selE7G">
                                        <option value=""></option>
                                        <optgroup label="NFC EAST">
                                        <option>Dallas Cowboys</option>
                                        <option>New York Giants</option>
                                        <option>Philadelphia Eagles</option>
                                        <option>Washington Redskins</option>
                                        </optgroup>
                                        <optgroup label="NFC NORTH">
                                        <option>Chicago Bears</option>
                                        <option>Detroit Lions</option>
                                        <option>Green Bay Packers</option>
                                        <option>Minnesota Vikings</option>
                                        </optgroup>
                                        <optgroup label="NFC SOUTH">
                                        <option>Atlanta Falcons</option>
                                        <option>Carolina Panthers</option>
                                        <option>New Orleans Saints</option>
                                        <option>Tampa Bay Buccaneers</option>
                                        </optgroup>
                                        <optgroup label="NFC WEST">
                                        <option>Arizona Cardinals</option>
                                        <option>St. Louis Rams</option>
                                        <option>San Francisco 49ers</option>
                                        <option>Seattle Seahawks</option>
                                        </optgroup>
                                        <optgroup label="AFC EAST">
                                        <option>Buffalo Bills</option>
                                        <option>Miami Dolphins</option>
                                        <option>New England Patriots</option>
                                        <option>New York Jets</option>
                                        </optgroup>
                                        <optgroup label="AFC NORTH">
                                        <option>Baltimore Ravens</option>
                                        <option>Cincinnati Bengals</option>
                                        <option>Cleveland Browns</option>
                                        <option>Pittsburgh Steelers</option>
                                        </optgroup>
                                        <optgroup label="AFC SOUTH">
                                        <option>Houston Texans</option>
                                        <option>Indianapolis Colts</option>
                                        <option>Jacksonville Jaguars</option>
                                        <option>Tennessee Titans</option>
                                        </optgroup>
                                        <optgroup label="AFC WEST">
                                        <option>Denver Broncos</option>
                                        <option>Kansas City Chiefs</option>
                                        <option>Oakland Raiders</option>
                                        <option>San Diego Chargers</option>
                                        </optgroup>
                                    </select><div id="selE7G_chzn" class="chzn-container chzn-container-single" style="width: 300px;"><a href="javascript:void(0)" class="chzn-single chzn-default" tabindex="13"><span>Your Favorite Football Team</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 298px; top: 28px;"><div class="chzn-search"><input type="text" autocomplete="off" style="width: 263px;" tabindex="-1"></div><ul class="chzn-results"><li id="selE7G_chzn_g_1" class="group-result">NFC EAST</li><li id="selE7G_chzn_o_2" class="active-result group-option" style="">Dallas Cowboys</li><li id="selE7G_chzn_o_3" class="active-result group-option" style="">New York Giants</li><li id="selE7G_chzn_o_4" class="active-result group-option" style="">Philadelphia Eagles</li><li id="selE7G_chzn_o_5" class="active-result group-option" style="">Washington Redskins</li><li id="selE7G_chzn_g_6" class="group-result">NFC NORTH</li><li id="selE7G_chzn_o_7" class="active-result group-option" style="">Chicago Bears</li><li id="selE7G_chzn_o_8" class="active-result group-option" style="">Detroit Lions</li><li id="selE7G_chzn_o_9" class="active-result group-option" style="">Green Bay Packers</li><li id="selE7G_chzn_o_10" class="active-result group-option" style="">Minnesota Vikings</li><li id="selE7G_chzn_g_11" class="group-result">NFC SOUTH</li><li id="selE7G_chzn_o_12" class="active-result group-option" style="">Atlanta Falcons</li><li id="selE7G_chzn_o_13" class="active-result group-option" style="">Carolina Panthers</li><li id="selE7G_chzn_o_14" class="active-result group-option" style="">New Orleans Saints</li><li id="selE7G_chzn_o_15" class="active-result group-option" style="">Tampa Bay Buccaneers</li><li id="selE7G_chzn_g_16" class="group-result">NFC WEST</li><li id="selE7G_chzn_o_17" class="active-result group-option" style="">Arizona Cardinals</li><li id="selE7G_chzn_o_18" class="active-result group-option" style="">St. Louis Rams</li><li id="selE7G_chzn_o_19" class="active-result group-option" style="">San Francisco 49ers</li><li id="selE7G_chzn_o_20" class="active-result group-option" style="">Seattle Seahawks</li><li id="selE7G_chzn_g_21" class="group-result">AFC EAST</li><li id="selE7G_chzn_o_22" class="active-result group-option" style="">Buffalo Bills</li><li id="selE7G_chzn_o_23" class="active-result group-option" style="">Miami Dolphins</li><li id="selE7G_chzn_o_24" class="active-result group-option" style="">New England Patriots</li><li id="selE7G_chzn_o_25" class="active-result group-option" style="">New York Jets</li><li id="selE7G_chzn_g_26" class="group-result">AFC NORTH</li><li id="selE7G_chzn_o_27" class="active-result group-option" style="">Baltimore Ravens</li><li id="selE7G_chzn_o_28" class="active-result group-option" style="">Cincinnati Bengals</li><li id="selE7G_chzn_o_29" class="active-result group-option" style="">Cleveland Browns</li><li id="selE7G_chzn_o_30" class="active-result group-option" style="">Pittsburgh Steelers</li><li id="selE7G_chzn_g_31" class="group-result">AFC SOUTH</li><li id="selE7G_chzn_o_32" class="active-result group-option" style="">Houston Texans</li><li id="selE7G_chzn_o_33" class="active-result group-option" style="">Indianapolis Colts</li><li id="selE7G_chzn_o_34" class="active-result group-option" style="">Jacksonville Jaguars</li><li id="selE7G_chzn_o_35" class="active-result group-option" style="">Tennessee Titans</li><li id="selE7G_chzn_g_36" class="group-result">AFC WEST</li><li id="selE7G_chzn_o_37" class="active-result group-option" style="">Denver Broncos</li><li id="selE7G_chzn_o_38" class="active-result group-option" style="">Kansas City Chiefs</li><li id="selE7G_chzn_o_39" class="active-result group-option" style="">Oakland Raiders</li><li id="selE7G_chzn_o_40" class="active-result group-option" style="">San Diego Chargers</li></ul></div></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="nonboxy-widget">
            <div class="widget-head">
                <h5> Sexy Checkbox, radio uniform</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <div class="checker" id="uniform-undefined"><span><input class="checkbox-b" type="checkbox" value="option1" style="opacity: 0;"></span></div>
                                    Option one</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Disabled checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <div class="checker disabled" id="uniform-undefined"><span><input class="checkbox-b" type="checkbox" disabled="" value="option1" style="opacity: 0;"></span></div>
                                    This is a disabled checkbox </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Inline checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox inline">
                                    <div class="checker" id="uniform-undefined"><span><input class="checkbox-b" type="checkbox" value="option1" style="opacity: 0;"></span></div>
                                    1 </label>
                                    <label class="checkbox inline">
                                    <div class="checker" id="uniform-undefined"><span><input class="checkbox-b" type="checkbox" value="option2" style="opacity: 0;"></span></div>
                                    2 </label>
                                    <label class="checkbox inline">
                                    <div class="checker" id="uniform-undefined"><span><input class="checkbox-b" type="checkbox" value="option3" style="opacity: 0;"></span></div>
                                    3 </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <div class="checker" id="uniform-undefined"><span><input class="checkbox-b" type="checkbox" value="option1" name="optionsCheckboxList1" style="opacity: 0;"></span></div>
                                    Option one</label>
                                    <label class="checkbox">
                                    <div class="checker" id="uniform-undefined"><span><input class="checkbox-b" type="checkbox" value="option2" name="optionsCheckboxList2" style="opacity: 0;"></span></div>
                                    Option two</label>
                                    <label class="checkbox">
                                    <div class="checker" id="uniform-undefined"><span><input class="checkbox-b" type="checkbox" value="option3" name="optionsCheckboxList3" style="opacity: 0;"></span></div>
                                    Option three</label>
                                    <p class="help-block">
                                        <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Radio buttons</label>
                                <div class="controls">
                                    <label class="radio">
                                    <div class="radio-btn" id="uniform-undefined"><span class="checked"><input class="radio-b" type="radio" checked="" value="option1" name="optionsRadios" style="opacity: 0;"></span></div>
                                    Option one</label>
                                    <label class="radio">
                                    <div class="radio-btn" id="uniform-undefined"><span><input class="radio-b" type="radio" value="option2" name="optionsRadios" style="opacity: 0;"></span></div>
                                    Option two</label>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="nonboxy-widget">
            <div class="widget-head">
                <h5> Tags Input</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input02">Tags</label>
                                <div class="controls">
                                    <input id="tags_1" type="text" class="tags" value="foo,bar,baz,roffle" style="display: none;"><div id="tags_1_tagsinput" class="tagsinput" style="width: 99%; min-height: 100px; height: 100%;"><span class="tag"><span>foo&nbsp;&nbsp;</span><a href="#" title="Removing tag">x</a></span><span class="tag"><span>bar&nbsp;&nbsp;</span><a href="#" title="Removing tag">x</a></span><span class="tag"><span>baz&nbsp;&nbsp;</span><a href="#" title="Removing tag">x</a></span><span class="tag"><span>roffle&nbsp;&nbsp;</span><a href="#" title="Removing tag">x</a></span><div id="tags_1_addTag"><input id="tags_1_tag" value="" data-default="add a test tag" style="color: rgb(102, 102, 102); width: 80px;"></div><div class="tags_clear"></div></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="nonboxy-widget">
            <div class="widget-head">
                <h5> Input Mask</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input01">Date</label>
                                <div class="controls">
                                    <input name="date" type="text" id="date">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Phone</label>
                                <div class="controls">
                                    <input name="phone" type="text" id="phone">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tin</label>
                                <div class="controls">
                                    <input name="tin" type="text" id="tin">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="typehead">ssn</label>
                                <div class="controls">
                                    <input name="ssn" type="text" id="ssn">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="nonboxy-widget">
            <div class="widget-head">
                <h5> File input Uniform</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">File input</label>
                                <div class="controls">
                                    <div class="uni-uploader" id="uniform-undefined"><input class="input-file" type="file" size="19" style="opacity: 0;"><span class="filename">No file selected</span><span class="action">Choose File</span></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="nonboxy-widget">
            <div class="widget-head">
                <h5> FOrm Grid and alternate size form elements</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Form grid sizes</label>
                                <div class="controls multiline-input">
                                    <input type="text" placeholder=".span1" class="span1">
                                    <input type="text" placeholder=".span2" class="span2">
                                    <input type="text" placeholder=".span3" class="span3">
                                    <select class="span1">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                    <select class="span2">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                    <select class="span3">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                    <p class="help-block">
                                         Use the same <code>.span*</code> classes from the grid system for input sizes.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Alternate sizes</label>
                                <div class="controls">
                                    <input type="text" placeholder=".input-mini" class="input-mini">
                                    <input type="text" placeholder=".input-small" class="input-small">
                                    <input type="text" placeholder=".input-medium" class="input-medium">
                                    <p class="help-block">
                                         You may also use static classes that don't map to the grid, adapt to the responsive CSS styles, or account for varying types of controls (e.g., <code>input</code> vs. <code>select</code>).
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="prependedInput" class="control-label">Prepended text</label>
                                <div class="controls">
                                    <div class="input-prepend">
                                        <span class="add-on">@</span>
                                        <input type="text" size="16" id="prependedInput" class="span8">
                                    </div>
                                    <p class="help-block">
                                         Here's some help text
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="appendedInput" class="control-label">Appended text</label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input type="text" size="16" id="appendedInput" class="span8">
                                        <span class="add-on margin-fix">.00</span>
                                    </div>
                                    <span class="help-inline">Here's more help text</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="appendedPrependedInput" class="control-label">Append and prepend</label>
                                <div class="controls">
                                    <div class="input-prepend input-append">
                                        <span class="add-on">$</span>
                                        <input type="text" size="16" id="appendedPrependedInput" class="span8">
                                        <span class="add-on">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="appendedInputButton" class="control-label">Append with button</label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input type="text" size="16" id="appendedInputButton" class="span8">
                                        <button type="button" class="btn margin-fix">Go!</button>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="appendedInputButtons" class="control-label">Two-button append</label>
                                <div class="controls">
                                    <div class="input-append">
                                        <input type="text" size="16" id="appendedInputButtons" class="span5">
                                        <button type="button" class="btn margin-fix">Search</button>
                                        <button type="button" class="btn margin-fix">Options</button>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Inline checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option1">
                                    1 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option2">
                                    2 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option3">
                                    3 </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" value="option1" name="optionsCheckboxList1">
                                    Option one</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option2" name="optionsCheckboxList2">
                                    Option two</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option3" name="optionsCheckboxList3">
                                    Option three</label>
                                    <p class="help-block">
                                        <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Radio buttons</label>
                                <div class="controls">
                                    <label class="radio">
                                    <input type="radio" checked="" value="option1" name="optionsRadios">
                                    Option one</label>
                                    <label class="radio">
                                    <input type="radio" value="option2" name="optionsRadios">
                                    Option two</label>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Save changes</button>
                                <button class="btn">Cancel</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-header">
    <h1>Form Elements <small>This is forms example with boxy widget</small></h1>
</div>
<div class="row-fluid">
    <div class="span7">
        <div class="widget-block">
            <div class="widget-head">
                <h5> Form ELements</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="form-horizontal well white-box">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input501">Text input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge text-tip" id="input501" data-original-title="first tooltip">
                                    <p class="help-block">
                                         In addition to freeform text, any HTML5 text-based input appears like so.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input502">Password Input</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" id="input502">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Uneditable input</label>
                                <div class="controls">
                                    <span class="input-xlarge uneditable-input">Some value here</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input504">Disable Input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge disabled" disabled="disabled" placeholder="Disabled input here…" id="input504">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" value="option1">
                                    Option one</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Disabled checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" disabled="" value="option1">
                                    This is a disabled checkbox </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Inline checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option1">
                                    1 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option2">
                                    2 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option3">
                                    3 </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" value="option1" name="optionsCheckboxList1">
                                    Option one</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option2" name="optionsCheckboxList2">
                                    Option two</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option3" name="optionsCheckboxList3">
                                    Option three</label>
                                    <p class="help-block">
                                        <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Select list</label>
                                <div class="controls">
                                    <select>
                                        <option>something</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Multicon-select</label>
                                <div class="controls">
                                    <select multiple="multiple">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">File input</label>
                                <div class="controls">
                                    <div class="uni-uploader" id="uniform-undefined"><input class="input-file" type="file" size="19" style="opacity: 0;"><span class="filename">No file selected</span><span class="action">Choose File</span></div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Textarea</label>
                                <div class="controls">
                                    <textarea class="input-xlarge" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button class="btn">Cancel</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="span5">
        <div class="widget-block">
            <div class="widget-head">
                <h5> Top Label form</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class="well white-box">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="input801">Text input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge text-tip" id="input801" data-original-title="first tooltip">
                                    <p class="help-block">
                                         In addition to freeform text, any HTML5 text-based input appears like so.
                                    </p>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" value="option1">
                                    Option one</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Disabled checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" disabled="" value="option1">
                                    This is a disabled checkbox </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Inline checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option1">
                                    1 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option2">
                                    2 </label>
                                    <label class="checkbox inline">
                                    <input type="checkbox" value="option3">
                                    3 </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Checkboxes</label>
                                <div class="controls">
                                    <label class="checkbox">
                                    <input type="checkbox" value="option1" name="optionsCheckboxList1">
                                    Option one</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option2" name="optionsCheckboxList2">
                                    Option two</label>
                                    <label class="checkbox">
                                    <input type="checkbox" value="option3" name="optionsCheckboxList3">
                                    Option three</label>
                                    <p class="help-block">
                                        <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
                                    </p>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button class="btn">Cancel</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget-block">
            <div class="widget-head">
                <h5> Left Label Uppercase</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class=" form-horizontal well white-box ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Text input</label>
                                <div class="controls">
                                    <input type="text" class=" input-medium text-tip" data-original-title="first tooltip">
                                    <p class="help-block">
                                         In addition to freeform text, any HTML5 text-based input appears like so.
                                    </p>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget-block">
            <div class="widget-head">
                <h5> Top Label Uppercase</h5>
            </div>
            <div class="widget-content">
                <div class="widget-box">
                    <form class=" well white-box ucase">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Text input</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge text-tip" data-original-title="first tooltip">
                                    <p class="help-block">
                                         In addition to freeform text, any HTML5 text-based input appears like so.
                                    </p>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: main -->