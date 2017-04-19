<?php
/**
 * @name SearchModel
 * @desc 搜索模型
 * @author root
 */
class SearchModel
{

    public function __construct()
    {
        $this->sphinx = new SphinxClient();
        $this->sphinx->setServer("localhost", 9312);
        $this->sphinx->setMatchMode(SPH_MATCH_ALL);       //匹配模式 ANY为关键词自动拆词，ALL为不拆词匹配（完全匹配）
        $this->sphinx->SetArrayResult(true);              //返回的结果集为数组
    }


    /**
     * 执行搜索 返回blogid字符串
     */
    public function search_ids($word)
    {

        $ids = [];
        if($word)
        {
            $result = $this->sphinx->query($word);            //星号为所有索引源
            if(!empty($result['matches']))
            {

                foreach($result['matches'] as $value)
                {
                    $ids[] = $value['id'];
                }
                return $ids;
            }
        }
        return $ids;
    }

}
