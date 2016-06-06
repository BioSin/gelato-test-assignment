<?php
namespace tests\codeception\common\models;


use Codeception\Specify;
use common\core\components\CurrencyConverter;
use common\models\Currency;
use common\models\Product;
use tests\codeception\common\fixtures\CurrencyFixture;
use tests\codeception\common\fixtures\CurrencyRateFixture;
use tests\codeception\common\fixtures\ProductFixture;
use tests\codeception\common\unit\DbTestCase;

class CurrencyConverterTest extends DbTestCase
{
    use Specify;

    /**
     * @var \tests\codeception\common\UnitTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function fixtures()
    {
        return [
            'currencies' => CurrencyFixture::className(),
            'rates' => CurrencyRateFixture::className(),
            'product' => ProductFixture::className()
        ];
    }

    public function testConvertInternal()
    {
        $this->specify('shall correct convert for specified amount', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-01-01');
            expect('For specified date',
                $this->invokeStaticMethod(CurrencyConverter::className(), 'convertInternal',
                    [Currency::ID_BASE, Currency::ID_RUB, 100, $date]))->equals(6500);
        });
    }

    /**
     * @depends testConvertInternal
     */
    public function testConvert()
    {
        $this->specify('shall process correct convert for Chargeable', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-01-01');

            /** @var Product $product */
            $product = Product::findOne(1);
            expect('For specified date',
                CurrencyConverter::convert($product, Currency::ID_RUB, Currency::ID_BASE, $date))->equals(6500);
        });

        $this->specify('shall throw exception for non-implementing Chargeable interface class', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-01-01');
            $product = new \stdClass();
            expect('For specified date',
                CurrencyConverter::convert($product, Currency::ID_RUB, Currency::ID_BASE, $date));
        }, ['throws' => 'yii\base\ErrorException']);
    }

    /**
     * @depends testConvertInternal
     */
    public function testConvertSum()
    {
        $this->specify('shall correct convert for specified amount', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-01-01');
            expect('For specified date',
                CurrencyConverter::convertSum(100, Currency::ID_RUB, Currency::ID_BASE, $date))->equals(6500);
        });

        $this->specify('shall throw exception for non-numeric amount value', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-01-01');
            $product = new \stdClass();
            expect('For specified date',
                CurrencyConverter::convertSum($product, Currency::ID_RUB, Currency::ID_BASE, $date));
        }, ['throws' => 'LogicException']);
    }

    private function invokeStaticMethod($object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs(null, $parameters);
    }
}