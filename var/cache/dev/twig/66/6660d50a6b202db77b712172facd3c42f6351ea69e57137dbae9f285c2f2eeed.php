<?php

/* @Framework/Form/checkbox_widget.html.php */
class __TwigTemplate_97f84cba036027b3815354ded6b88be556a78664ec2b5f65f80fbdd1ed4ac8db extends Twig_Template
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
        $__internal_140c7386ffc8cb764480e02713c43523bee9d7c7c02c59170684a3e64c603582 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_140c7386ffc8cb764480e02713c43523bee9d7c7c02c59170684a3e64c603582->enter($__internal_140c7386ffc8cb764480e02713c43523bee9d7c7c02c59170684a3e64c603582_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/checkbox_widget.html.php"));

        $__internal_9d2abd364f8592c892c3c216e6be91b22a54b3f839767a7bf83dbd2a3418fe63 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_9d2abd364f8592c892c3c216e6be91b22a54b3f839767a7bf83dbd2a3418fe63->enter($__internal_9d2abd364f8592c892c3c216e6be91b22a54b3f839767a7bf83dbd2a3418fe63_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/checkbox_widget.html.php"));

        // line 1
        echo "<input type=\"checkbox\"
    <?php echo \$view['form']->block(\$form, 'widget_attributes') ?>
    <?php if (strlen(\$value) > 0): ?> value=\"<?php echo \$view->escape(\$value) ?>\"<?php endif ?>
    <?php if (\$checked): ?> checked=\"checked\"<?php endif ?>
/>
";
        
        $__internal_140c7386ffc8cb764480e02713c43523bee9d7c7c02c59170684a3e64c603582->leave($__internal_140c7386ffc8cb764480e02713c43523bee9d7c7c02c59170684a3e64c603582_prof);

        
        $__internal_9d2abd364f8592c892c3c216e6be91b22a54b3f839767a7bf83dbd2a3418fe63->leave($__internal_9d2abd364f8592c892c3c216e6be91b22a54b3f839767a7bf83dbd2a3418fe63_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/checkbox_widget.html.php";
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
        return new Twig_Source("<input type=\"checkbox\"
    <?php echo \$view['form']->block(\$form, 'widget_attributes') ?>
    <?php if (strlen(\$value) > 0): ?> value=\"<?php echo \$view->escape(\$value) ?>\"<?php endif ?>
    <?php if (\$checked): ?> checked=\"checked\"<?php endif ?>
/>
", "@Framework/Form/checkbox_widget.html.php", "C:\\xampp\\htdocs\\Proyecto\\vendor\\symfony\\symfony\\src\\Symfony\\Bundle\\FrameworkBundle\\Resources\\views\\Form\\checkbox_widget.html.php");
    }
}