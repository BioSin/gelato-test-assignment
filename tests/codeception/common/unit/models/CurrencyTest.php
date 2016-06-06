<?php
namespace tests\codeception\common\models;


use Codeception\Specify;
use common\models\Currency;
use tests\codeception\common\fixtures\CurrencyFixture;
use tests\codeception\common\fixtures\CurrencyRateFixture;
use tests\codeception\common\unit\DbTestCase;

class CurrencyTest extends DbTestCase
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
            'rates' => CurrencyRateFixture::className()
        ];
    }

    /**
     *
     */
    public function testResolve()
    {
        $this->specify('method may accept different types of argument',
            function () {
                expect('return value is instance of Currency model for correct id',
                    Currency::resolve(1))->isInstanceOf(Currency::class);
                expect('return value is instance of Currency model for correct system_name',
                    Currency::resolve('USD'))->isInstanceOf(Currency::class);

                $instance = Currency::findOne(1);
                expect('return same instance as passed instance as argument',
                    Currency::resolve($instance))->same($instance);
            });

        $this->specify('method shall throw InvalidArgumentException for non correct argument values', function () {
            expect('for non-exist id', Currency::resolve(100));
        }, ['throws' => 'InvalidArgumentException']);
        $this->specify('method shall throw InvalidArgumentException for non correct argument values', function () {
            expect('for non-exist system_name', Currency::resolve('USDD'));
        }, ['throws' => 'InvalidArgumentException']);
        $this->specify('method shall throw InvalidArgumentException for non correct argument values', function () {
            expect('for incorrect instance', Currency::resolve(new \stdClass()));
        }, ['throws' => 'InvalidArgumentException']);
    }

    /**
     * @depends testResolve
     */
    public function testGetRates()
    {
        $this->specify('shall get correct rates for specified date', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-01-01');
            expect('', Currency::getRates($date))->internalType('array');
            expect('',
                Currency::getRates($date))->count(2); // check what we have 2 elements in array, because we have only 2 currency
        });
        $this->specify('shall return empty array for non updated day', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-02-01');
            expect('', Currency::getRates($date))->isEmpty();
        });
    }

    /**
     * @depends testGetRates
     */
    public function testExchange()
    {
        $this->specify('shall correctly convert amount between currencies', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-01-01');

            expect('from bigger to smaller currency by rate',
                Currency::exchange(Currency::ID_USD, Currency::ID_RUB, 1, $date))->equals(65);
            expect('from smaller to bigger currency by rate',
                Currency::exchange(Currency::ID_RUB, Currency::ID_USD, 65, $date))->equals(1);
            expect('correct handle same value convert',
                Currency::exchange(Currency::ID_RUB, Currency::ID_RUB, 1, $date))->equals(1);
        });

        $this->specify('shall throw exception for incorrect exchange data', function () {
            $date = \DateTime::createFromFormat('Y-m-d', '2016-02-01');

            expect('from bigger to smaller currency by rate',
                Currency::exchange(Currency::ID_USD, Currency::ID_RUB, 1, $date))->equals(65);
        }, ['throws' => 'LogicException']);
    }
}