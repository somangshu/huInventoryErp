<?php $this->load->view('/common/menu'); ?>
<?php 
  if(isset($isPagination) && $isPagination=="Yes") 
    { 
?>
    <form name="paginationForm" id="paginationForm" method="POST">
      <input type="hidden" name="firstPage" id="firstPage" value="<?php echo $firstPage;?>">
      <input type="hidden" name="previousPage" id="previousPage" value="<?php echo $previousPage;?>">
      <input type="hidden" name="nextPage" id="nextPage" value="<?php echo $nextPage;?>">
      <input type="hidden" name="lastPage" id="lastPage" value="<?php echo $lastPage;?>">
      <input type="hidden" name="pageNumber" id="pageNumber" value="<?php echo $pageNo;?>">
      <input type="hidden" name="totalPages" id="totalPages" value="<?php echo $lastPage;?>">
      <input type="hidden" name="totalResultCount" id="totalResultCount" value="<?php echo $custCnt;?>">
      <input type="hidden" name="pageLength" id="pageLength" value="<?php echo $pageSize;?>">
    </form>
      <table style="width:100%;">
      <tr>
      <?php 
        $limitStart = ( ($pageNow-1) * $pageSize ) + 1;
        $limitEnd   = ( $custCnt > ($pageNo * $pageSize) ) ? $pageNo * $pageSize : $custCnt;
      ?>
        <td style="width:30%;height:100%;font-size:13px;font-weight:normal;font-style:italic;color:#03809C;text-align:left;">
          <?php echo "Showing ".$limitStart."-".$limitEnd." of ".$custCnt." results"; ?>
        </td>
        
        <td style="width:40%;text-align:center;font-size:13px;color:grey;font-family:serif;">
          <a href="#" onclick="javascript:goToFirstPagevsm('<?php echo $pageUrl; ?>','<?php echo $formName; ?>');" title="First Page">&lt;&lt;</a>&nbsp;&nbsp;
          
          <a href="#" onclick="javascript:goToPrevPagevsm('<?php echo $pageUrl; ?>','<?php echo $formName; ?>');" title="Previous Page">&lt;</a>&nbsp;&nbsp;
          
          <label for="pageNo">Page No.</label>
          
          <input type="text" id="pageNo" name="pageNo" style="width:25px;" value="<?php echo $pageNo; ?>" onkeypress="if(event.keyCode==13) {javascript:changePageNumbervsm('<?php echo $pageUrl; ?>','<?php echo $formName; ?>');}" >&nbsp;&nbsp;
          
          <a href="#" onclick="javascript:goToNextPagevsm('<?php echo $pageUrl; ?>','<?php echo $formName; ?>');" title="Next Page">&gt;</a>&nbsp;&nbsp;
          
          <a href="#" onclick="javascript:goToLastPagevsm('<?php echo $pageUrl; ?>','<?php echo $formName; ?>');" title="Last Page">&gt;&gt;</a>&nbsp;&nbsp;
          
          <label for="pageSize">Page Size</label>
          
          <input type="text" id="pageSize" name="pageSize" style="width:25px;" value="<?php echo $pageSize; ?>" onkeypress="if(event.keyCode==13) {javascript:changeSizevsm('<?php echo $pageUrl; ?>','<?php echo $formName; ?>');}">
        </td>
      </tr>
    </table>
  <?php 
    } 
  ?>