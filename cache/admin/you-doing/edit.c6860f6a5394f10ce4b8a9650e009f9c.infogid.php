<?php if(!class_exists('Template')){exit;}?><h3><i class="fa fa-angle-right"></i> Edit "<? echo $info["title"];?>"</h3>

<div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
            <form
                    class="form-horizontal style-form"
                    method="post" action="/admin/you-doing/ajax/edit/<? echo $info["id"];?>"
                    id="you-doing-add"
                    data-redirect="/admin/you-doing">

                <div class="form-group control-label">
                    <label class="col-sm-2 control-label">Image</label>

                    <div class="col-sm-3 controls">
                        <img src="<? echo $info["base64"];?>" style="width: 250px">
                        <input type="file" name="file" id="file" style="position: absolute; left: -1000000000px;"
                               data-msg-required="Add File">
                        <button type="button" class="btn btn-success image-click">Edit Image</button>
                        <input type="hidden" name="image_base64" value="<? echo $info["base64"];?>">
                    </div>
                </div>

                <div class="form-group control-label">
                    <label class="col-sm-2 control-label">Title</label>

                    <div class="col-sm-3 controls">
                        <input type="text" class="form-control" value="<? echo $info["title"];?>" name="title" id="title"
                               data-msg-required="Enter Title">
                    </div>
                </div>

                <div class="form-group control-label">
                    <label class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-3 controls">
                        <textarea class="form-control" name="description" id="description"
                                  data-msg-required="Enter Description"><? echo $info["description"];?></textarea>
                    </div>
                </div>

                <div class="form-group control-label">
                    <label class="col-sm-2 control-label">Type of social network</label>

                    <div class="col-sm-3 controls">
                        <select class="form-control" name="social" id="social">
                            <option value="twitter" <?php if( $info["social"] == 'twitter' ){ ?>selected="" <?php } ?>>Twitter</option>
                            <option value="instagram" <?php if( $info["social"] == 'instagram' ){ ?>selected="" <?php } ?>>Instagram</option>
                        </select>
                    </div>
                </div>

                <div class="form-group control-label">
                    <div class="col-sm-3 controls">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="/static/admin/js/you-doing.js"></script>