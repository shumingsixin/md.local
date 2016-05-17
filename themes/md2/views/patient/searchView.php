<?php
$this->setPageTitle('搜索');
$urlAjaxSearch = $this->createUrl('patient/ajaxSearch');
$urlPatientView = $this->createUrl('patient/view', array('id' => ''));
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section class="active">
        <nav id="patientSearchView_nav" class="header-secondary">
            <div class="w100 pl10 pr10 grid">
                <div class="col-1">
                    <input type="text" placeholder="请输入患者姓名">
                </div>
                <div id="searchBtn" class="col-0 pt5 pl10 color-black">
                    搜索
                </div>
            </div>
        </nav>
        <article id="searchView_article" class="active" data-scroll="true">
            <div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('#searchBtn').click(function () {
            var searchName = $('input').val();
            if (searchName == '') {
                J.showToast('请输入患者姓名', '', '1000');
            } else {
                $.ajax({
                    url: '<?php echo $urlAjaxSearch; ?>?name=' + searchName,
                    success: function (data) {
                        var structureData = structure_data(data);
                        var returnData = do_decrypt(structureData);
                        returnData = analysis_data(returnData);
                        readyPage(returnData);
                    }
                });
            }
        });
        function readyPage(data) {
            var patientList = data.results.patientList;
            var html = '<div>';
            if (patientList == null) {
                html += '<div class="text-center mt50">无数据</div>';
            } else {
                for (var i = 0; i < patientList.length; i++) {
                    var patient = patientList[i];
                    var yearly = patient.age;
                    var yearlyText = '';
                    var monthly = "";
                    if (yearly == 0 && patient.ageMonth >= 0) {
                        yearlyText = '';
                        monthly = patient.ageMonth + '个月';
                    } else if (yearly <= 5 && patient.ageMonth > 0) {
                        yearlyText = yearly + '岁';
                        monthly = patient.ageMonth + '个月';
                    } else if (yearly > 5 && patient.ageMonth > 0) {
                        yearly++;
                        yearlyText = yearly + '岁';
                    } else {
                        yearlyText = yearly + '岁';
                    }
                    html += '<div class="bb5-gray">' +
                            '<div class="mt10 ml10 mr10 mb10">' +
                            '<a href="<?php echo $urlPatientView; ?>/' + patient.id + '/addBackBtn/1" class="color-000" data-target="link">' +
                            '<div class="">' +
                            '<div class=" mb10">' + patient.name + '</div>' +
                            '<div class=" mb10">' + patient.gender + ' &nbsp;|&nbsp; ' + yearlyText + monthly + ' &nbsp;|&nbsp; ' + patient.cityName + '</div>' +
                            '<div class=" mb10">' + patient.diseaseName + '</div>' +
                            '</div>' +
                            '</a>' +
                            '</div>' +
                            '</div>'
                }
            }
            html += '</div>';
            $('#searchView_article').html(html);
        }
    });
</script>