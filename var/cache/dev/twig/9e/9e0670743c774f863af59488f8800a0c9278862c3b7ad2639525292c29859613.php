<?php

/* @Framework/Form/submit_widget.html.php */
class __TwigTemplate_03aa938eff914b1994a708e7be68a2bea04bb846366d3fd1ea4e8aacc9edf4f8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_1085e270fae67cfabaf1da7d8c7343bcc6e767035fdfb7fa5d875b4a6b77eb16 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_1085e270fae67cfabaf1da7d8c7343bcc6e767035fdfb7fa5d875b4a6b77eb16->enter($__internal_1085e270fae67cfabaf1da7d8c7343bcc6e767035fdfb7fa5d875b4a6b77eb16_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/submit_widget.html.php"));

        $__internal_1e9cde922abf19d4490784d30118d9c776c3b640cc3a61e192a2d426e1a28fab = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_1e9cde922abf19d4490784d30118d9c776c3b640cc3a61e192a2d426e1a28fab->enter($__internal_1e9cde922abf19d4490784d30118d9c776c3b640cc3a61e192a2d426e1a28fab_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/submit_widget.html.php"));

        // line 1
        echo "<?php echo \$view['form']->block(\$form, 'button_widget', array('type' => isset(\$type) ? \$type : 'submit')) ?>
";
        
        $__internal_1085e270fae67cfabaf1da7d8c7343bcc6e767035fdfb7fa5d875b4a6b77eb16->leave($__internal_1085e270fae67cfabaf1da7d8c7343bcc6e767035fdfb7fa5d875b4a6b77eb16_prof);

        
        $__internal_1e9cde922abf19d4490784d30118d9c776c3b640cc3a61e192a2d426e1a28fab->leave($__internal_1e9cde922abf19d4490784d30118d9c776c3b640cc3a61e192a2d426e1a28fab_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/submit_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<?php echo \$view['form']->block(\$form, 'button_widget', array('type' => isset(\$type) ? \$type : 'submit')) ?>
", "@Framework/Form/submit_widget.html.php", "C:\\xampp\\htdocs\\Proyecto\\vendor\\symfony\\symfony\\src\\Symfony\\Bundle\\FrameworkBundle\\Resources\\views\\Form\\submit_widget.html.php");
    }
}
