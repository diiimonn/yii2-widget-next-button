<?php
namespace diiimonn\widgets;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use yii\helpers\Json;

/**
 * Class NextButton
 * @package diiimonn\widgets
 */
class NextButton extends Widget
{
    public $options = [];

    public $containerOptions = [];

    public $buttonOptions = [];

    public static $buttonContainerOptions = [];

    public $scriptOptions = [];

    public $isNext = true;

    /**
     * @var \yii\web\AssetBundle
     */
    protected $asset;

    public function init()
    {
        parent::init();

        $this->registerAsset();
        $this->registerClientScript();

        $this->options['id'] = $this->id;
        Html::addCssClass($this->options, 'nb__container');

        echo Html::beginTag('div', $this->options);

        Html::addCssClass($this->containerOptions, 'nb__items');

        echo Html::beginTag('div', $this->containerOptions);
    }

    public function run()
    {
        Html::addCssClass($this->buttonOptions, 'nb__button');

        return $this->isNext ? Html::a('+ ' . Yii::t('app', 'Show next ...'), '#', $this->buttonOptions) : '';
    }

    public static function end()
    {
        echo Html::endTag('div');

        Html::addCssClass(static::$buttonContainerOptions, 'nb__button_container');

        echo Html::beginTag('div', static::$buttonContainerOptions);

        echo Html::beginTag('div', ['class' => 'row']);
        echo Html::beginTag('div', ['class' => 'col-md-6 col-md-offset-3']);

        $widget = parent::end();

        echo Html::endTag('div');
        echo Html::endTag('div');
        echo Html::endTag('div');
        echo Html::endTag('div');

        return $widget;
    }

    protected function registerClientScript()
    {
        $view = $this->getView();
        $script = '$(".nb__button", $("#' . $this->id . '")).nextButton(' . Json::encode($this->scriptOptions) . ');';
        $view->registerJs($script, $view::POS_END);
    }

    protected function registerAsset()
    {
        $this->asset = NextButtonAsset::register($this->getView());
    }
}
