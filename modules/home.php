<?php
$load = new Load();

$parentDir = Load::getParentDir();

$dataScan = $load->scanDir($parentDir);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS);
    $old = filter_input(INPUT_POST,'old',FILTER_SANITIZE_SPECIAL_CHARS);
    Make::rename($parentDir, $old,$name);
    redirect('?path=');
}

?>
<form action="" method="post" id="form-filemanager">
    <table id="dataTable">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkAll" /></th>
                <th>Tên</th>
                <th>Dung lượng</th>
                <th>Cập nhật cuối</th>
                <th>Quyền</th>
                <th class="text-end">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // $load->back(); 
            if (!empty($dataScan)):
                foreach ($dataScan as $item):
                    if ($item !== '.DS_Store'):
                        $path = $load->getPath($item);
                        if ($load->isType($path) == 'folder') {
                            $targetPath = str_replace(_DATA_DIR . '/', '', $path);
                        } else {
                            $targetPath = '';
                        }

                        $dataTypeArr = [
                            'type' => $load->isType($path),
                            'name' => $item
                        ];

                        ?>

                        <tr>

                            <td><input type="checkbox" class="check-item"></td>
                            <td>
                                <a href="?path=<?php echo urlencode($targetPath) ?>">
                                    <?php echo $load->getTypeIcon($item) . ' ' . $item ?></a>
                            </td>
                            <td>
                                <?php echo $load->getSize($item, 'KB') ?>
                            </td>
                            <td>
                                <?php echo $load->getTimeModify($item) ?>
                            </td>
                            <td>
                                <?php echo $load->getPermission($item) ?>
                            </td>
                            <td class="text-end">
                                <?php if ($load->isType($path) == 'file'): ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye mx-1" aria-hidden="true"></i></a>
                                <?php endif; ?>
                                <a href="?module=remove_item&type=action&path=<?php echo $parentDir ?>&filename=<?php echo urlencode($item); ?>" onclick="return confirm('Bạn có chắc chắn')" class="btn btn-primary btn-sm"><i class="fa fa-trash mx-1" aria-hidden="true"></i></a>
                                <a href="#" class="btn btn-primary btn-sm edit-action"
                                    data-type='<?php echo json_encode($dataTypeArr); ?>'><i class="fa fa-pencil-square-o mx-1"
                                        aria-hidden="true"></i></a>
                                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-files-o mx-1" aria-hidden="true"></i></a>
                                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-link mx-1" aria-hidden="true"></i></a>
                                <?php if ($load->isType($path) == 'file'): ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-download mx-1"
                                            aria-hidden="true"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; endforeach; endif; ?>

        </tbody>
    </table>
    <input type="hidden" name="name" value="">
    <input type="hidden" name="old" value="">
</form>