<h3><i class="fa fa-angle-right"></i> Edit "{$info.title}"</h3>

<div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
            <form
                    class="form-horizontal style-form"
                    method="post" action="/admin/you-doing/ajax/edit/{$info.id}"
                    id="you-doing-add"
                    data-redirect="/admin/you-doing">

                <div class="form-group control-label">
                    <label class="col-sm-2 control-label">Image</label>

                    <div class="col-sm-3 controls">
                        <img src="{$info.base64}" style="width: 250px">
                        <input type="file" name="file" id="file" style="position: absolute; left: -1000000000px;"
                               data-msg-required="Add File">
                        <button type="button" class="btn btn-success image-click">Edit Image</button>
                        <input type="hidden" name="image_base64" value="{$info.base64}">
                    </div>
                </div>

                <div class="form-group control-label">
                    <label class="col-sm-2 control-label">Title</label>

                    <div class="col-sm-3 controls">
                        <input type="text" class="form-control" value="{$info.title}" name="title" id="title"
                               data-msg-required="Enter Title">
                    </div>
                </div>

                <div class="form-group control-label">
                    <label class="col-sm-2 control-label">Description</label>

                    <div class="col-sm-3 controls">
                        <textarea class="form-control" name="description" id="description"
                                  data-msg-required="Enter Description">{$info.description}</textarea>
                    </div>
                </div>

                <div class="form-group control-label">
                    <label class="col-sm-2 control-label">Type of social network</label>

                    <div class="col-sm-3 controls">
                        <select class="form-control" name="social" id="social">
                            <option value="twitter" {if="$info.social == 'twitter'"}selected="" {/if}>Twitter</option>
                            <option value="instagram" {if="$info.social == 'instagram'"}selected="" {/if}>Instagram</option>
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