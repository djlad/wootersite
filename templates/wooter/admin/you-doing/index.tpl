<h3><i class="fa fa-angle-right"></i> You Doing</h3>
<div class="row">
    <div class="col-md-12">
        <div class="content-panel">
            <table class="table" data-target="/admin/you-doing/ajax/delete" data-msg="Are You Sure?">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Social</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                {foreach="$doings as $item"}
                    <tr data-id="{$item.id}">
                        <td>{$item.id}</td>
                        <td>{$item.title}</td>
                        <td>{$item.social}</td>
                        <td style="width: 200px">
                            <a href="/admin/you-doing/edit/{$item.id}" alt="Edit" title="Edit">
                                <button class="btn btn-primary "><i class="fa fa-pencil"></i></button>
                            </a>
                            <button class="btn btn-danger delete" alt="Delete" title="Delete"><i
                                        class="fa fa-trash-o "></i>
                            </button>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>