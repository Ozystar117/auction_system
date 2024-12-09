<?php


class Image
{
    private $id, $path, $itemLotID;
    public function __construct($dbRow){
        $this->id = $dbRow['imageID'];
        $this->path = $dbRow['imagePath'];
        $this->itemLotID = $dbRow['itemLotID'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getItemLotID()
    {
        return $this->itemLotID;
    }


}