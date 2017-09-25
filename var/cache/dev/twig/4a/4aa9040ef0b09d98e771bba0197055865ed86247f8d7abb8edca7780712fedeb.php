<?php

/* :user:index.html.twig */
class __TwigTemplate_aa6756dfdc3f681c0b933b87a2e8333dad576afee7dbbf0710001eaab2a27778 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", ":user:index.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_415f6aad40722fa6f708c4c8943ce36e72b2c3a7eef1d5fdebc8a0f1cc895bda = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_415f6aad40722fa6f708c4c8943ce36e72b2c3a7eef1d5fdebc8a0f1cc895bda->enter($__internal_415f6aad40722fa6f708c4c8943ce36e72b2c3a7eef1d5fdebc8a0f1cc895bda_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":user:index.html.twig"));

        $__internal_5658507c322ff35c49ebdd70c583ebfbea1f993d84439d8362c9dd747068fe30 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_5658507c322ff35c49ebdd70c583ebfbea1f993d84439d8362c9dd747068fe30->enter($__internal_5658507c322ff35c49ebdd70c583ebfbea1f993d84439d8362c9dd747068fe30_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":user:index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_415f6aad40722fa6f708c4c8943ce36e72b2c3a7eef1d5fdebc8a0f1cc895bda->leave($__internal_415f6aad40722fa6f708c4c8943ce36e72b2c3a7eef1d5fdebc8a0f1cc895bda_prof);

        
        $__internal_5658507c322ff35c49ebdd70c583ebfbea1f993d84439d8362c9dd747068fe30->leave($__internal_5658507c322ff35c49ebdd70c583ebfbea1f993d84439d8362c9dd747068fe30_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_7b11d17abe1720c6fc764d350a6898e42c8b6d6492b4fc8dac1900be96a5e7d4 = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_7b11d17abe1720c6fc764d350a6898e42c8b6d6492b4fc8dac1900be96a5e7d4->enter($__internal_7b11d17abe1720c6fc764d350a6898e42c8b6d6492b4fc8dac1900be96a5e7d4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        $__internal_0150fb44116156ff0296f465f5280fdf8aa9e854f26a26fc72f2e2033b144e9a = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_0150fb44116156ff0296f465f5280fdf8aa9e854f26a26fc72f2e2033b144e9a->enter($__internal_0150fb44116156ff0296f465f5280fdf8aa9e854f26a26fc72f2e2033b144e9a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "    <h1>Users list</h1>

    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Isactive</th>
                <th>Email</th>
                <th>Legajo</th>
                <th>Iduser</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        ";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["users"]) || array_key_exists("users", $context) ? $context["users"] : (function () { throw new Twig_Error_Runtime('Variable "users" does not exist.', 19, $this->getSourceContext()); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 20
            echo "            <tr>
                <td><a href=\"";
            // line 21
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("user_show", array("iduser" => twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "iduser", array()))), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "username", array()), "html", null, true);
            echo "</a></td>
                <td>";
            // line 22
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "password", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 23
            if (twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "isActive", array())) {
                echo "Yes";
            } else {
                echo "No";
            }
            echo "</td>
                <td>";
            // line 24
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "email", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 25
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "legajo", array()), "html", null, true);
            echo "</td>
                <td>";
            // line 26
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "iduser", array()), "html", null, true);
            echo "</td>
                <td>
                    <ul>
                        <li>
                            <a href=\"";
            // line 30
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("user_show", array("iduser" => twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "iduser", array()))), "html", null, true);
            echo "\">show</a>
                        </li>
                        <li>
                            <a href=\"";
            // line 33
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("user_edit", array("iduser" => twig_get_attribute($this->env, $this->getSourceContext(), $context["user"], "iduser", array()))), "html", null, true);
            echo "\">edit</a>
                        </li>
                    </ul>
                </td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        echo "        </tbody>
    </table>

    <ul>
        <li>
            <a href=\"";
        // line 44
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("user_new");
        echo "\">Create a new user</a>
        </li>
    </ul>
";
        
        $__internal_0150fb44116156ff0296f465f5280fdf8aa9e854f26a26fc72f2e2033b144e9a->leave($__internal_0150fb44116156ff0296f465f5280fdf8aa9e854f26a26fc72f2e2033b144e9a_prof);

        
        $__internal_7b11d17abe1720c6fc764d350a6898e42c8b6d6492b4fc8dac1900be96a5e7d4->leave($__internal_7b11d17abe1720c6fc764d350a6898e42c8b6d6492b4fc8dac1900be96a5e7d4_prof);

    }

    public function getTemplateName()
    {
        return ":user:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  131 => 44,  124 => 39,  112 => 33,  106 => 30,  99 => 26,  95 => 25,  91 => 24,  83 => 23,  79 => 22,  73 => 21,  70 => 20,  66 => 19,  49 => 4,  40 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'base.html.twig' %}

{% block body %}
    <h1>Users list</h1>

    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Isactive</th>
                <th>Email</th>
                <th>Legajo</th>
                <th>Iduser</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        {% for user in users %}
            <tr>
                <td><a href=\"{{ path('user_show', { 'iduser': user.iduser }) }}\">{{ user.username }}</a></td>
                <td>{{ user.password }}</td>
                <td>{% if user.isActive %}Yes{% else %}No{% endif %}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.legajo }}</td>
                <td>{{ user.iduser }}</td>
                <td>
                    <ul>
                        <li>
                            <a href=\"{{ path('user_show', { 'iduser': user.iduser }) }}\">show</a>
                        </li>
                        <li>
                            <a href=\"{{ path('user_edit', { 'iduser': user.iduser }) }}\">edit</a>
                        </li>
                    </ul>
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    <ul>
        <li>
            <a href=\"{{ path('user_new') }}\">Create a new user</a>
        </li>
    </ul>
{% endblock %}
", ":user:index.html.twig", "C:\\xampp\\htdocs\\Proyecto\\app/Resources\\views/user/index.html.twig");
    }
}
