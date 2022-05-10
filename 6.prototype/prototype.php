<?php
declare(strict_types=1);


// =================================================

// class HelloClone
// {
//     private int $num;
//     private string $builtInConstructor;
//     public function __construct(int $num)
//     {
//         echo "hell Clone!".PHP_EOL;
//         $this->builtInConstructor = "create Constructor";
//         $this->num = ++$num;
//         echo "construct number : ". $num.PHP_EOL;
//     }

//     public function doWork()
//     {
//         echo $this->builtInConstructor . PHP_EOL;
//         echo "I work".PHP_EOL;
//         echo "number :  ". ++$this->num.PHP_EOL;
//     }
// }

// $original = new HelloClone(0);
// $original->doWork();    


// $cloneIt = clone $original; // cloneした場合はコンストラクタが実行されない
// $cloneIt->doWork();
// $cloneIt->doWork();




// =================================================

// https://learning.oreilly.com/library/view/learning-php-design/9781449344900/ch06.html#what_is_the_prototype_design_pattern_que
// abstract class IPrototype
// {
//     public $eyeColor;
//     public $wingBeat;
//     public $unitEyes;

//     abstract function __clone();
// }

// class MaleProto extends IPrototype
// {
//     const gender = "MALE";
//     public $mated;

//     public function __construct()
//     {
//         $this->eyeColor = "red";
//         $this->wingBeat = "111";
//         $this->unitEyes = "333";

//     }

//     function __clone() {}
// }

// class FemaleProto extends IPrototype
// {
//     const gender = "FEMALE";
//     public $fecundity;

//     public function __construct()
//     {
//         $this->eyeColor = "blue";
//         $this->wingBeat = "222";
//         $this->unitEyes = "444";
//     }

//     function __clone() {}
// }

// class Client
// {
//     private $fly1;
//     private $fly2;

//     private $c1Fly;
//     private $c2Fly;
//     private $updatedCloneFly;

//     public function __construct()
//     {
//         $this->fly1 = new MaleProto();
//         $this->fly2 = new FemaleProto();

//         // Clone
//         $this->c1Fly = clone $this->fly1;

//         $this->c2Fly = clone $this->fly2;
//         $this->updatedCloneFly = clone $this->fly2;

//         // update clone
//         $this->c1Fly->mated = "true";
//         $this->c2Fly->fecundity = "186";

//         $this->updatedCloneFly->eyeColor = "purple";
//         $this->updatedCloneFly->wingBeat = "333";
//         $this->updatedCloneFly->unitEyes = "666";
//         $this->updatedCloneFly->fecundity = "999";

//         // Send through type hinting method
//         $this->showFly($this->c1Fly);
//         $this->showFly($this->c2Fly);
//         $this->showFly($this->updatedCloneFly);
//     }

//     private function showFly(IPrototype $fly)
//     {
//         echo "Eye color: " . $fly->eyeColor . PHP_EOL;
//         echo "WInd Beats/second: " . $fly->wingBeat . PHP_EOL;
//         echo "Eye units: " . $fly->unitEyes . PHP_EOL;
//         $genderNow = $fly::gender;
//         echo "Gender: " . $genderNow . PHP_EOL;

//         if ($genderNow === "FEMALE") {
//             echo "F eggs: " . $fly->fecundity . PHP_EOL;
//         } else {
//             echo "M eggs: " . $fly->mated . PHP_EOL;
//         }

//         echo "---------------------" . PHP_EOL;
//     }
// }

// $worker = new Client();


// ===============================================



/**
 * Prototype パターン
 * setterがあるあまり良い例ではない
 * つまりあまりよいパターンではないのかも
 * 
 * やっていることは
 * 部門ごとに所属する人を表示している
 * 
 * ただし、それぞれの部門クラスの生成は1度だけで
 * cloneでインスタンスを使い回している
 * 
 * singletonとはちがうのかな？
 * 
 * 出典: https://learning.oreilly.com/library/view/learning-php-design/9781449344900/ch06.html
 */
abstract class IAcmePRototype
{
    protected $name;
    protected $id;
    protected $employeePic;
    protected $dept;

    abstract function setDept($orgCode);
    abstract function getDept();

    public function setName($emName)
    {
        $this->name = $emName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setID($emId)
    {
        $this->id = $emId;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setPic($emPic)
    {
        $this->employeePic = $emPic;
    }

    public function getPic()
    {
        return $this->employeePic;
    }

    abstract function __clone();
}

class Marketing extends IAcmePRototype
{
    const UNIT = "Marketing";
    private $sales = "sales";
    private $promotion = "promotion";
    private $strategic = "strategic planning";

    public function setDept($orgCode)
    {
        switch($orgCode)
        {
            case 101:
                $this->dept = $this->sales;
                break;
            case 102:
                $this->dept = $this->promotion;
                break;
            case 103:
                $this->dept = $this->strategic;
                break;
            default:
                $this->dept = "Unrecognized Marketing";
        }
    }

    public function getDept()
    {
        return $this->dept;
    }

    function __clone() {}
}


class Management extends IAcmePRototype
{
    const UNIT = "Management";
    private $research = "research";
    private $plan = "planning";
    private $operations = "operations";

    public function setDept($orgCode)
    {
        switch($orgCode)
        {
            case 201:
                $this->dept = $this->research;
                break;
            case 202:
                $this->dept = $this->plan;
                break;
            case 203:
                $this->dept = $this->operations;
                break;
            default: 
                $this->dept = "Unrecognized Management";
        }
    }

    public function getDept()
    {
        return $this->dept;
    }

    function __clone() {}
}

class Engineering extends IAcmePRototype
{
    const UNIT = "Engineering";
    private $development = "programming";
    private $design = "digital artwork";
    private $sysAd = "system administration";

    public function setDept($orgCode)
    {
        switch($orgCode)
        {
            case 301:
                $this->dept = $this->development;
                break;
            case 302:
                $this->dept = $this->design;
                break;
            case 303:
                $this->dept = $this->sysAd;
                break;
            default: 
                $this->dept = "Unrecognized Engineering";
        }
    }

    public function getDept()
    {
        return $this->dept;
    }

    function __clone() {}
}



class Client 
{
    private $market;
    private $manage;
    private $engineer;

    public function __construct()
    {
        $this->makeConProto();

        $Tess = clone $this->market;
        $this->setEmployee($Tess, "Tess Smith", 101, "ts101-1234", "tes.png");
        $this->showEmployee($Tess);

        $Jacob = clone $this->market;
        $this->setEmployee($Jacob, "Jacob Jones", 102, "jj102-1234", "jacob.png");
        $this->showEmployee($Jacob);

        $Ricky = clone $this->manage;
        $this->setEmployee($Ricky, "Ricky Jones", 203, "jj102-1234", "ricky.png");
        $this->showEmployee($Ricky);

        $Olivia = clone $this->engineer;
        $this->setEmployee($Olivia, "Olivia Perez", 302, "jj102-1234", "olivia.png");
        $this->showEmployee($Olivia);

        $John = clone $this->engineer;
        $this->setEmployee($John, "John Jackson", 301, "jj102-1234", "john.png");
        $this->showEmployee($John);
    }

    private function makeConProto()
    {
        $this->market = new Marketing();
        $this->manage = new Management();
        $this->engineer = new Engineering();
    }

    private function showEmployee(IAcmePRototype $employeeNow)
    {
        $px = $employeeNow->getPic();
        echo "px  : " . $px.PHP_EOL;
        echo "name: " . $employeeNow->getName().PHP_EOL;
        echo "Dept: " . $employeeNow->getDept().PHP_EOL;
        echo "ID  : " . $employeeNow->getID().PHP_EOL;
    }

    private function setEmployee(
        IAcmePRototype $employeeNow,
        string $nm,
        int $id,
        string $dp,
        string $px
    )
    {
        $employeeNow->setName($nm);
        $employeeNow->setDept($dp);
        $employeeNow->setID($id);
        $employeeNow->setPic("pix/$px");
    }
}

$worker = new Client();
