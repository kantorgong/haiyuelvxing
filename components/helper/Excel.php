<?php
namespace components\helper;

use yii;
use EasyWeChat\Foundation\Application;
use yii\base\Component;
//Yii::import('components.excel.*');
require dirname(dirname(__FILE__)).'/phpexcel/PHPExcel.php';
require dirname(dirname(__FILE__)).'/phpexcel/PHPExcel/Writer/Excel5.php';
require dirname(dirname(__FILE__)).'/phpexcel/PHPExcel/Writer/Excel2007.php';

/**
 * 生成excel文件操作
 *
 * @author wesley wu
 * @date 2013.12.9
 */
class Excel extends Component
{
     
private $_objWriter;
    private $_objExcel;
    private $_file_name;
    private $_objActSheet;
    private $_index = 1;
    private $_objProps;
    private $_ext = "xlsx";
    private $_charset = "utf-8";
    private $_vesion = 2007;
    private $_file_columns = array();
    private $_columns = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

    /**
     * 初始化版本，字符，以及对象
     * @param String $charset 字符编码
     * @param Int $version 版本号
     * @param Int $pIndex 当前sheet索引
     */
    public function __construct($columns = 26, $charset = "utf-8", $version = "2007", $pIndex = 0)
    {
        $this->_objExcel = new \PHPExcel();
        $this->_charset = $charset;
        $this->_vesion = $version;
        if (2003 == $this->_vesion)
        {
            $this->_objWriter = new \PHPExcel_Writer_Excel5($this->_objExcel);
            $this->_ext = "xls";
        }
        else
        {
            $this->_objWriter = new \PHPExcel_Writer_Excel2007($this->_objExcel);
        }
        $this->_objActSheet = $this->_objExcel->getActiveSheet();
        $this->_objProps = $this->_objExcel->getProperties();
        $this->_objExcel->setActiveSheetIndex($pIndex);
        $this->__makeFileColumns($columns);
    }
    
    /**
     * 确定文件使用那些索引
     */
    private function __makeFileColumns($columns = 26)
    {
        if (26 >= $columns)
        {
            $column_pieces = array_chunk($this->_columns, 26);
            $this->_file_columns = array_shift($column_pieces);
        }

        $multiple = ceil($columns / 26);
        $index = 0;
        $file_columns = $this->_columns;
        while ($index < $multiple)
        {
            if (0 == $index)
            {
                $index++;
                continue;
            }

            foreach ($this->_columns as $col)
            {
                $file_columns[] = $this->_columns[$index - 1] . $col;
            }
            $index++;
        }

        $column_pieces = array_chunk($file_columns, $columns);
        $this->_file_columns = array_shift($column_pieces);
    }

    /**
     * 初始化excel信息
     * @param Array $params 参数数组
     */
    public function init($params)
    {
        $creator = iconv("utf-8", $this->_charset, empty($params["creator"]) ? "xmen" : $params["creator"] );
        $this->_objProps->setCreated($creator);
        $modify = iconv("utf-8", $this->_charset, empty($params["modify"]) ? "xmen" : $params["modify"] );
        $this->_objProps->setLastModifiedBy($modify);
        $descrip = iconv("utf-8", $this->_charset, empty($params["descrip"]) ? "xmenExcel" : $params["descrip"] );
        $this->_objProps->setDescription($descrip);
        $title = iconv("utf-8", $this->_charset, empty($params["title"]) ? "xmen" : $params["title"] );
        $this->_objProps->setTitle($title);
        $subject = iconv("utf-8", $this->_charset, empty($params["subject"]) ? "xmenExcel" : $params["subject"] );
        $this->_objProps->setSubject($subject);
        $keywords = iconv("utf-8", $this->_charset, empty($params["keywords"]) ? "xmen" : $params["keywords"] );
        $this->_objProps->setKeywords($keywords);
        $category = iconv("utf-8", $this->_charset, empty($params["category"]) ? "xmen" : $params["category"] );
        $this->_objProps->setCategory($category);
        $file_name = iconv("utf-8", $this->_charset, empty($params["file_name"]) ? date("Y-m-d") : $params["file_name"] );
        $this->_file_name = $file_name . "." . $this->_ext;
    }

    /**
     * 使用excel制表时使用此函数，方法采取合并单元格方式来调整表格样式，注意表格中不包含图片操作
     * @param Array $titles 标题数组，如果数组元素为数组，则表示需要合并单元格，数组必须包含以下两个元素：value，merge。
     * value：当前单元格的值
     * merge：单元格跨度，如，A1:C1表示合并三个单元格。
     * @author zhengzp
     * @datetime 2015-02-26
     */
    public function setTitles($titles)
    {
        //先切分成长度为26的数组
        $key = 0;
        //第一片数组
        foreach ($titles as $title)
        {
            $width = 20;
            $mkey = $this->_file_columns[$key] . $this->_index;
            //若是数组且不为空说明设置了宽度
            if (is_array($title) && 0 < count($title))
            {
                if(isset($title["width"]))
                {
                    $width = $title["width"];
                }
                $name = iconv("utf-8", $this->_charset, $title["name"]);
                if (isset($title['merge']))
                {
                    $this->_objActSheet->mergeCells($title['merge']);
                    $key += $title['span'] - 1;
                }
            }
            else
            {
                $name = iconv("utf-8", $this->_charset, $title);
            }
            $this->_objActSheet->getStyle($mkey)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->_objActSheet->getStyle($mkey)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->_objActSheet->getColumnDimension($this->_file_columns[$key])->setWidth($width);
            $this->_objActSheet->setCellValue($mkey, $name);
            $key++;
        }

        $this->_index++;
    }

    /**
     * 往表格中添加数据，方法采取合并单元格方式来调整表格样式，注意表格中不包含图片操作
     * @param Array $datas 二维数组，若第二维数组中元素为数组，说明需要操作单元格，数组必须包含以下三个元素：merge_type，span，value。
     * merge_type:只能为row，col。为row时表示合并行，被合并的部分填写false，为col表示合并列。
     * span：表示合并几个单元格
     * value：当前单元格的值
     * @author zhengzp
     * @datetime 2015-02-26
     */
    public function pushDatas($datas)
    {
        foreach ($datas as $data)
        {
            $k = 0;
            foreach ($data as $d)
            {
                if (FALSE === $d)
                {
                    $k++;
                    continue;
                }
                $key = $this->_file_columns[$k] . $this->_index;
                $this->_objActSheet->getStyle($key)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->_objActSheet->getStyle($key)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                //普通操作不需要拆分或合并单元格直接SET值
                if (!is_array($d))
                {
                    $value = iconv("utf-8", $this->_charset, $d);
                    $this->_objActSheet->setCellValue($key, $value);
                    $k++;
                    continue;
                }
                //如果是数组表示需要合并单元格，row表示合并hang，col表示合并列
                if ("row" == $d['merge_type'])
                {
                    $span = $key . ":{$this->_file_columns[$k]}" . ($this->_index + $d['span'] - 1);
                }
                if ("col" == $d['merge_type'])
                {
                    $k = $k + $d['span'] - 1;
                    $span = $key . ":{$this->_file_columns[$k]}{$this->_index}";
                }
                $this->_objActSheet->mergeCells($span);
                $value = iconv("utf-8", $this->_charset, $d['value']);
                $this->_objActSheet->setCellValue($key, $value);
                $k++;
            }
            $this->_index++;
        }
    }

    /**
     * 导出EXCEL
     */
    function export()
    {
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename={$this->_file_name}");
        header("Content-Transfer-Encoding:binary");
        $this->_objWriter->save("php://output");
    }
     
}