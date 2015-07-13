<?php $this->Combinator->add_libs('css', $this->Less->css('missing')) ?>
<?php
if (!isset($code_desc)) {
    $code_desc = 'Coś poszło nie tak';
}
if (!isset($action)) {
    $action = 'main_page';
}
?>

<div class="container">
    <div class="informationBlock missing col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
        <div class="mathFunction col-xs-12">
            <math class="hidden-xs hidden-sm">
                <mtable>
                    <mtr>
                        <mstyle scriptlevel="-1">
                            <msubsup>
                                <mo>&Integral;</mo>
                                <mn>1</mn>
                                <mn>5</mn>
                            </msubsup>
                        </mstyle>
                        <mstyle scriptlevel="0">
                            <mrow>
                                <mn>9</mn>
                                <mo>⁢</mo>
                                <mi>x</mi>
                                <msup>
                                    <mi></mi>
                                    <mn>2</mn>
                                </msup>
                            </mrow>
                            <mo>+</mo>
                            <mrow>
                                <mn>4</mn>
                                <mo>⁢</mo>
                                <mi>x</mi>
                            </mrow>
                            <mo>+</mo>
                            <mn>2</mn>

                            <mo rspace="mediummathspace">&InvisibleTimes;</mo>
                            <mo rspace="0">&DifferentialD;</mo>
                            <mi>x</mi>
                            <mo>=</mo>
                            <mo rspace="mediummathspace">&InvisibleTimes;</mo>
                            <mfenced open="[" close="]">
                                <mtable>
                                    <mtr>
                                        <mtd>
                                            <mo rspace="20px">&InvisibleTimes;</mo>
                                            <mrow>
                                                <mn>3</mn>
                                                <mo>⁢</mo>
                                                <mi>x</mi>
                                                <msup>
                                                    <mi></mi>
                                                    <mn>3</mn>
                                                </msup>
                                            </mrow>
                                            <mo>+</mo>
                                            <msup>
                                                <mi>x</mi>
                                                <mn>2</mn>
                                            </msup>
                                            <mo>+</mo>
                                            <mrow>
                                                <mn>2</mn>
                                                <mo>⁢</mo>
                                                <mi>x</mi>
                                            </mrow>
                                            <mo rspace="20px">&InvisibleTimes;</mo>
                                        </mtd>
                                    </mtr>
                                </mtable>
                            </mfenced>
                            <msup>
                                <mi></mi>
                                <mn>5</mn>
                            </msup>
                            <mo>,</mo>
                        </mstyle>
                    </mtr>
                    <mtr>
                        <mstyle scriptlevel="0">
                            <mo rspace="135px">&InvisibleTimes;</mo>
                            <mo>=</mo>
                            <mo rspace="mediummathspace">&InvisibleTimes;</mo>
                            <mfenced open="[" close="]">
                                <mtable>
                                    <mtr>
                                        <mtd>
                                            <mn>3</mn>
                                            <mfenced>
                                                <mrow>
                                                    <mn>5</mn>
                                                </mrow>
                                            </mfenced>
                                            <msup>
                                                <mi></mi>
                                                <mn>2</mn>
                                            </msup>
                                            <mo>+</mo>
                                            <mfenced>
                                                <mrow>
                                                    <mn>5</mn>
                                                </mrow>
                                            </mfenced>
                                            <msup>
                                                <mi></mi>
                                                <mn>2</mn>
                                            </msup>
                                            <mo>+</mo>
                                            <mn>2</mn>
                                            <mfenced>
                                                <mrow>
                                                    <mn>5</mn>
                                                </mrow>
                                            </mfenced>
                                        </mtd>
                                    </mtr>
                                </mtable>
                            </mfenced>
                            <mo>-</mo>
                            <mfenced open="[" close="]">
                                <mtable>
                                    <mtr>
                                        <mtd>
                                            <mn>3</mn>
                                            <mfenced>
                                                <mrow>
                                                    <mn>1</mn>
                                                </mrow>
                                            </mfenced>
                                            <msup>
                                                <mi></mi>
                                                <mn>3</mn>
                                            </msup>
                                            <mo>+</mo>
                                            <mfenced>
                                                <mrow>
                                                    <mn>1</mn>
                                                </mrow>
                                            </mfenced>
                                            <msup>
                                                <mi></mi>
                                                <mn>2</mn>
                                            </msup>
                                            <mo>+</mo>
                                            <mn>2</mn>
                                            <mfenced>
                                                <mrow>
                                                    <mn>1</mn>
                                                </mrow>
                                            </mfenced>
                                        </mtd>
                                    </mtr>
                                </mtable>
                            </mfenced>
                        </mstyle>
                    </mtr>
                </mtable>
            </math>
        </div>
        <div class="col-xs-12 information">
            <h4><?php echo $code; ?></h4>

            <h2><strong>Ups!</strong><?php echo $code_desc; ?></h2>

            <h3><?php echo $message; ?></h3>
            <?php if ($action == 'refresh') { ?>
                <a class="btn btn-info" href="<? echo Router::reverse($this->params); ?>" target="_self">Odśwież
                    stronę</a>
            <?php } else { ?>
                <a class="btn btn-info" href="/" target="_self">Wróć na stronę główną</a>
            <?php } ?>
        </div>
    </div>
</div>

<? if (Configure::read('debug') > 0) { ?>
    <div class="error-description">
        <h3><?php echo get_class($error); ?></h3>

        <p><?php echo $error->getMessage(); ?></p>
        <?php echo $this->element('exception_stack_trace'); ?>
    </div>
<? } ?>
