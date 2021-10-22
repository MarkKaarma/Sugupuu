<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:msxsl="urn:schemas-microsoft-com:xslt" exclude-result-prefixes="msxsl"
>
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
      <h2>Perhe</h2>
      <ul>
        <xsl:for-each select="//inimene">
          <xsl:sort select="@synn"/>
          <li>
            <xsl:value-of select="concat(nimi, ' ', @synn)"/>
          </li>
        </xsl:for-each>
      </ul>
      <br></br>
      <strong>  
      Tingimuslause if kasutamine - näitame ainult need inimesi, kellel esivanema andmed on teada <!---->
      </strong>
      <br></br>
      <ul>
        <xsl:for-each select="//inimene">
          <xsl:sort select="@synn" order="ascending"/>
          <li>
            <xsl:value-of select="concat(nimi, ' ', @synn)"/>
            <xsl:if test="../..">
              - lapsevanem <xsl:value-of select ="../../nimi"/>
            </xsl:if>
          </li>
        </xsl:for-each>
      </ul>
      <br></br>
      <strong>
        Tingimuslause if kasutamine - Mitu last kellelgi on?
      </strong>
      <br></br>
      <ul>
        <xsl:for-each select="//inimene[lapsed]">
          <li>
            <xsl:value-of select="nimi"/>
            <xsl:value-of select="count(lapsed/inimene)"/>
            <xsl:if test="count(lapsed/inimene)=1">
              laps
            </xsl:if>
            <xsl:if test="not(count(lapsed/inimene)=1)">
              last
            </xsl:if>
          </li>
        </xsl:for-each>
      </ul>
      <br></br>
      <strong>Iga inimese kohta kirjuta kõik tema järglase</strong>
      <ul>
        <xsl:for-each select="//inimene[lapsed]">
          <xsl:sort select="@synn" order="ascending"/>
          <li>
            <xsl:value-of select="nimi"/>:
            <xsl:for-each select="lapsed//inimene">
              <xsl:value-of select="nimi"/>
              <xsl:if test="not(position()=last())">, 
              </xsl:if>
            </xsl:for-each>
          </li>
        </xsl:for-each>
      </ul>
      <br></br>
      <strong>Trüki välja kõikide inimeste sünniaastad: </strong>
      <br></br>
      Kasvamine:
      <xsl:for-each select="//inimene">
        <xsl:sort select="@synn" order="ascending"/>
          <xsl:value-of select="concat(@synn, ', ')"/>
      </xsl:for-each>
      <br></br>
      Kahanemine:
      <xsl:for-each select="//inimene">
        <xsl:sort select="@synn" order="descending"/>
        <xsl:value-of select="concat(@synn, ', ')"/>
      </xsl:for-each>
      <br></br>
      <strong>Väljastatakse nimed, kel on vähemalt kaks last</strong>
      <ul>
        <xsl:for-each select="//inimene">
          <xsl:sort select="@synn" order="ascending"/>
          <xsl:if test="count(lapsed/inimene) >= 2">
            <li>
              <xsl:value-of select="nimi"/>
            </li>
          </xsl:if>
        </xsl:for-each>
      </ul>
      <br></br>
      <strong>Väljasta sugupuus leiduvad andmed tabelina</strong>
        <table border="1">
          <tr bgcolor="#00ff00">
            <th style="text-align:left">Nimi</th>
            <th style="text-align:left">Sünniaasta</th>
            <th style="text-align:left">Vanus</th>
            <th style="text-align:left">Vanema vanus lapse sündimisel</th>
            <th style="text-align:left">Lapsevanem</th>
            <th style="text-align:left">Esivanem</th>
          </tr>
        <xsl:for-each select="//inimene/lapsed/inimene">
          <tr>
            <td>
              <xsl:value-of select="nimi"/>
            </td>
            <td>
              <xsl:value-of select="@synn"/>
            </td>
            <td>
              <xsl:value-of select="2021-@synn"/>
            </td>
            <td>
              <xsl:value-of select="@synn - ../../@synn"/>
            </td>
            <td>
              <xsl:value-of select="../../nimi"/>
            </td>
            <td>
              <xsl:value-of select="../../../../nimi"/>
            </td>
          </tr>
        </xsl:for-each>
        </table>
        <br></br>
        <strong>Sisaldab nimi - "A". </strong>
        <xsl:for-each select="//inimene">
          <xsl:if test="contains(nimi, 'A') or contains(nimi, 'A') or string-length(nimi)=5">
            <xsl:value-of select="nimi"/>, 
          </xsl:if>
      </xsl:for-each>
      <br></br>
      <table>
        <tr>
        <xsl:for-each select="//inimene">
          <xsl:if test="string-length(nimi) &lt;= 7">
            <td style="background-color: green">
            <xsl:value-of select="nimi"/>
            </td>
          </xsl:if>
          <xsl:if test="string-length(nimi) &gt;= 10">
            <td style="background-color: red">
            <xsl:value-of select="nimi"/>
            </td>
          </xsl:if>
          <xsl:if test="string-length(nimi) &gt; 7 and string-length(nimi) &lt; 10">
            <td style="background-color: white">
              <xsl:value-of select="nimi"/>
            </td>
          </xsl:if>
        </xsl:for-each>
      </tr>
      </table>
      
    </xsl:template>
</xsl:stylesheet>
