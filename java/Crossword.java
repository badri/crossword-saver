import java.applet.Applet;

import java.awt.Color;
import java.awt.Event;
import java.awt.Font;
import java.awt.FontMetrics;
import java.awt.Graphics;
import java.awt.Image;

import java.net.MalformedURLException;
import java.net.URL;

public class Crossword extends Applet implements Runnable
{

    public String getClueTitle()
    {
        StringBuffer stringbuffer = new StringBuffer("");
        if(R * C == 0)
            return "Welcome to the CrosswordSaver Java Applet";
        int i = 1;
        if(Across)
        {
            for(; xword[R][C - i] % 10 != 0; i++);
            int j = (xword[R][(C - i) + 1] % 10000) / 100;
            stringbuffer.append(j);
            stringbuffer.append(" Across: ");
        } else
        {
            for(; xword[R - i][C] % 10 != 0; i++);
            int k = (xword[(R - i) + 1][C] % 10000) / 100;
            stringbuffer.append(k);
            stringbuffer.append(" Down: ");
        }
        String s = new String(stringbuffer);
        return s;
    }

    public String getClueGuess()
    {
        StringBuffer stringbuffer = new StringBuffer("");
        if(R * C == 0)
            return "";
        int i = 1;
        if(Across)
        {
            for(; xword[R][C - i] % 10 != 0; i++);
            for(i--; xword[R][C - i] % 10 != 0; i--)
            {
                Character character = new Character((char)(xword[R][C - i] / 10000));
                String s1 = new String(character.toString().toUpperCase());
                stringbuffer.append(s1);
            }

        } else
        {
            for(; xword[R - i][C] % 10 != 0; i++);
            for(i--; xword[R - i][C] % 10 != 0; i--)
            {
                Character character1 = new Character((char)(xword[R - i][C] / 10000));
                String s2 = new String(character1.toString().toUpperCase());
                stringbuffer.append(s2);
            }

        }
        String s = new String(stringbuffer);
        return s;
    }

    public String getClueString()
    {
        StringBuffer stringbuffer = new StringBuffer("");
        if(R * C == 0)
            return "Welcome to the Crossword";
        int i = 1;
        if(Across)
        {
            for(; xword[R][C - i] % 10 != 0; i++);
            int j = (xword[R][(C - i) + 1] % 10000) / 100;
            stringbuffer.append(j);
            int l = j;
            stringbuffer.append(" Across: ");
            stringbuffer.append(clue[l][0]);
        } else
        {
            for(; xword[R - i][C] % 10 != 0; i++);
            int k = (xword[(R - i) + 1][C] % 10000) / 100;
            stringbuffer.append(k);
            int i1 = k;
            stringbuffer.append(" Down: ");
            stringbuffer.append(clue[i1][1]);
        }
        String s = new String(stringbuffer);
        return s;
    }

    public String getClueSubString(String s, int i, int j)
    {
        int k = s.length();
        if(k == 0)
            return "";
        if(k <= j)
        {
            if(i == 1)
                return s;
        } else
        if(k > j && k <= j * 2)
        {
            int l = s.indexOf(" ", j);
            if(l == -1)
                l = k;
            for(; l > j || s.charAt(l) != ' '; l--);
            if(i == 1)
                return s.substring(0, l);
            if(i == 2 && l < k)
                return s.substring(l + 1, k);
        } else
        {
            int i1 = s.indexOf(" ", j);
            int j1 = s.indexOf(" ", j * 2);
            if(i1 == -1)
                i1 = k;
            if(j1 == -1)
                j1 = k;
            if(i == 1)
                return s.substring(0, i1);
            if(i == 2)
                return s.substring(i1 + 1, j1);
            if(i == 3 && j1 < k)
                return s.substring(j1 + 1, k);
        }
        return "";
    }

    public String stripNonAlpha(String s)
    {
        String s1 = new String("");
        if(s == null)
            return "";
        for(int j = 0; j < s.length(); j++)
        {
            int i = s.charAt(j);
            if(i >= 65 && i <= 90 || i >= 97 && i <= 122)
            {
                Character character = new Character((char)i);
                s1 = s1 + character.toString();
            }
        }

        return s1;
    }

    public String trunc(String s)
    {
        int i = s.length();
        if(i == 0)
            return "";
        if(i <= 60)
            return s;
        int j = s.indexOf(" ", 55);
        if(j == -1)
            j = i;
        return s.substring(0, j) + "...";
    }

    public boolean mouseMove(Event event, int i, int j)
    {
        int k = overMode;
        if(j - 25 < 0)
        {
            if(i < 72)
                overMode = 1;
            else
            if(i < 144)
                overMode = 2;
            else
            if(i < 192)
            {
                overMode = 0;
            } else
            {
                if(i < 240)
                    return true;
                if(i < 300)
                    overMode = 5;
                else
                if(i < 360)
                    overMode = 3;
                else
                if(i < 434 && i > 362)
                    overMode = 6;
                else
                if(i < 506 && i > 362)
                    overMode = 7;
            }
            if(overMode == k)
                return true;
            if(k == 1)
                repaint(0, 0, 72, 25);
            else
            if(k == 2)
                repaint(72, 0, 72, 25);
            else
            if(k == 0)
                repaint(144, 0, 48, 25);
            else
            if(k == 5)
                repaint(240, 0, 60, 25);
            else
            if(k == 3)
                repaint(300, 0, 61, 25);
            else
            if(k == 6)
                repaint(362, 0, 72, 25);
            else
            if(k == 7)
                repaint(434, 0, 72, 25);
            if(overMode == 1)
                repaint(0, 0, 72, 25);
            else
            if(overMode == 2)
                repaint(72, 0, 72, 25);
            else
            if(overMode == 0)
                repaint(144, 0, 48, 25);
            else
            if(overMode == 5)
                repaint(240, 0, 60, 25);
            else
            if(overMode == 3)
                repaint(300, 0, 61, 25);
            else
            if(overMode == 6)
                repaint(362, 0, 72, 25);
            else
            if(overMode == 7)
                repaint(434, 0, 72, 25);
        } else
        {
            overMode = -1;
            if(k == 1)
                repaint(0, 0, 72, 25);
            else
            if(k == 2)
                repaint(72, 0, 72, 25);
            else
            if(k == 0)
                repaint(144, 0, 48, 25);
            else
            if(k == 5)
                repaint(240, 0, 60, 25);
            else
            if(k == 3)
                repaint(300, 0, 61, 25);
            else
            if(k == 6)
                repaint(362, 0, 72, 25);
            else
            if(k == 7)
                repaint(434, 0, 72, 25);
            if(i > 360 || j > 385)
            {
                overMode = -1;
                return true;
            } else
            {
                return true;
            }
        }
        return true;
    }

  /**
   * Changes the <code>Color</code> of the current <code>Graphics</code> object.
   * @param g The current <code>Graphics</code> context.
   */
  public void setColour( Graphics g ){
    switch( colour ){
      case( 0 ):
      g.setColor( Color.black.brighter() );
      break;
      case( 1 ):
      g.setColor( Color.CYAN );
      break;
      case( 2 ):
      g.setColor( Color.YELLOW );
      break;
      case( 3 ):
      g.setColor( Color.RED );
      break;
      case( 4 ):
      g.setColor( Color.BLUE );
      break;
      case( 5 ):
      g.setColor( Color.GREEN );
      break;
      case( 6 ):
      g.setColor( Color.MAGENTA );
      break;
      case( 7 ):
      g.setColor( Color.ORANGE );
      break;
      case( 8 ):
      g.setColor( Color.PINK );
      break;
      case( 9 ):
      g.setColor( Color.GRAY );
      break;
      default:
      g.setColor( Color.black.brighter() );
    }
  }

    public boolean keyDown( Event event, int i ){
        System.out.println("KEY(" + i + ")");
        if(drawMode == 0)
        {
            if(xword[R][C] % 10 == 1 && event.key >= 65 && event.key <= 90 || event.key >= 97 && event.key <= 122 || event.key == 32 || event.key == 8 || event.key >= 48 && event.key < 58 || event.key >= 1004 && event.key <= 1007)
            {
                int j = 1;
                do
                {
                    int k1 = 1;
                    do
                        if((xword[j][k1] % 100) / 10 > 0)
                        {
                            xword[j][k1] -= ((xword[j][k1] % 100) / 10) * 10;
                            repaint((k1 - 1) * 24, (j - 1) * 24 + 25, 24, 24);
                        }
                    while(++k1 <= 15);
                } while(++j <= 15);
                if(event.key >= 1004 && event.key <= 1007)
                {
                    if(event.key == 1004)
                    {
                        if(xword[R - 1][C] % 10 == 1)
                            R--;
                        Across = false;
                    }
                    if(event.key == 1005)
                    {
                        if(xword[R + 1][C] % 10 == 1)
                            R++;
                        Across = false;
                    }
                    if(event.key == 1006)
                    {
                        if(xword[R][C - 1] % 10 == 1)
                            C--;
                        Across = true;
                    }
                    if(event.key == 1007)
                    {
                        if(xword[R][C + 1] % 10 == 1)
                            C++;
                        Across = true;
                    }
                    repaint(0, 386, 360, 49);
                } else
                if(event.key == 8)
                {
                    if(xword[R][C] / 10000 > 0)
                    {
                        repaint((C - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                        xword[R][C] -= (xword[R][C] / 10000) * 10000;
                    }
                    if(!Across)
                    {
                        if(xword[R - 1][C] % 10 == 1)
                            R--;
                    } else
                    if(xword[R][C - 1] % 10 == 1)
                        C--;
                } else
                {
                    if(event.key >= 65 && event.key <= 90 || event.key >= 97 && event.key <= 122)
                    {
                        if(xword[R][C] / 10000 > 0)
                        {
                            repaint((C - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                            xword[R][C] -= (xword[R][C] / 10000) * 10000;
                        }
                        xword[R][C] += event.key * 10000;
                    } else
                    if(event.key == 32)
                    {
                        if(xword[R][C] / 10000 > 0)
                        {
                            repaint((C - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                            xword[R][C] -= (xword[R][C] / 10000) * 10000;
                        }
                    } else
                    if(event.key >= 48 && event.key < 58)
                    {
                        colour = event.key - 48;
                        repaint();
                    }
                    if(Across)
                    {
                        if(xword[R][C + 1] % 10 == 1)
                        {
                            C++;
                            C1 = C;
                        }
                    } else
                    if(xword[R + 1][C] % 10 == 1)
                    {
                        R++;
                        R1 = R;
                    }
                }
                xword[R][C] += 10;
                repaint((C - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                if(xword[R - 1][C] % 10 + xword[R + 1][C] % 10 == 0)
                    Across = true;
                if(xword[R][C - 1] % 10 + xword[R][C + 1] % 10 == 0)
                    Across = false;
                if(Across)
                {
                    for(int k = 1; xword[R][C + k] % 10 == 1; k++)
                    {
                        if((xword[R][C + k] % 100) / 10 > 0)
                            xword[R][C + k] -= ((xword[R][C + k] % 100) / 10) * 10;
                        xword[R][C + k] += 20;
                        repaint(((C + k) - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                    }

                    for(int l = 1; xword[R][C - l] % 10 == 1; l++)
                    {
                        if((xword[R][C - l] % 100) / 10 > 0)
                            xword[R][C - l] -= ((xword[R][C - l] % 100) / 10) * 10;
                        xword[R][C - l] += 20;
                        repaint((C - l - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                    }

                } else
                {
                    for(int i1 = 1; xword[R + i1][C] % 10 == 1; i1++)
                    {
                        if((xword[R + i1][C] % 100) / 10 > 0)
                            xword[R + i1][C] -= ((xword[R + i1][C] % 100) / 10) * 10;
                        xword[R + i1][C] += 20;
                        repaint((C - 1) * 24, ((R + i1) - 1) * 24 + 25, 24, 24);
                    }

                    for(int j1 = 1; xword[R - j1][C] % 10 == 1; j1++)
                    {
                        if((xword[R - j1][C] % 100) / 10 > 0)
                            xword[R - j1][C] -= ((xword[R - j1][C] % 100) / 10) * 10;
                        xword[R - j1][C] += 20;
                        repaint((C - 1) * 24, (R - j1 - 1) * 24 + 25, 24, 24);
                    }

                }
            }
        } else
        {
            if(drawMode == 3 && event.key == 65)
            {
                thestr = " BETA  VERSION ";
                UC = true;
                repaint();
            } else
            if(drawMode == 3 && event.key == 66)
            {
                UC = false;
                repaint();
            } else
            if(drawMode == 3 && event.key == 90)
                repaint();
            if(event.key >= 65 && event.key <= 90)
            {
                comment = event.key - 64;
                repaint(0, 386, 360, 45);
            } else
            if(event.key == 32)
            {
                guessMode = 1 - guessMode;
                repaint(0, 25, 360, 20);
            }
        }
        repaint(365, 25, 245, 360);
        return true;
    }

    public boolean mouseDown(Event event, int i, int j)
    {
        System.out.println("MOU(" + i + "," + j + ")");
        if(j - 25 < 0)
        {
            if(i < 72)
            {
                drawMode = 1;
                repaint();
                return true;
            }
            if(i < 144)
            {
                drawMode = 2;
                repaint();
                return true;
            }
            if(i < 192)
            {
                drawMode = 0;
                repaint();
                return true;
            }
            if(i < 240)
                return true;
            if(i < 300)
            {
                drawMode = 5;
                repaint();
                return true;
            }
            if(i < 360)
            {
                drawMode = 3;
                repaint();
                return true;
            }
            if(i < 434)
            {
                ClueListAcross = true;
                repaint();
                return true;
            }
            if(i < 506)
            {
                ClueListAcross = false;
                repaint();
                return true;
            } else
            {
                return true;
            }
        }
        if(i > 365 && j > 385)
        {
            try
            {
                getAppletContext().showDocument(new URL(getParameter("AdvertClick")), "_self");
            }
            catch(MalformedURLException malformedurlexception)
            {
                System.out.println("Malformed URL:" + malformedurlexception.getMessage());
            }
            return true;
        }
        if(i > 360 || j > 385)
        {
            R = R1;
            C = C1;
            return true;
        }
        switch(drawMode)
        {
        case 3: // '\003'
        case 4: // '\004'
        default:
            break;

        case 0: // '\0'
            R1 = R;
            C1 = C;
            R = (j - 25) / 24 + 1;
            C = i / 24 + 1;
            System.out.println("MDN(" + R + "," + C + ")");
            if(R == R1 && C == C1)
                Across = !Across;
            else
                Across = true;
            if(xword[R][C] % 10 == 1)
            {
                int k = 1;
                do
                {
                    int k4 = 1;
                    do
                        if((xword[k][k4] % 100) / 10 > 0)
                        {
                            xword[k][k4] -= ((xword[k][k4] % 100) / 10) * 10;
                            repaint((k4 - 1) * 24, (k - 1) * 24 + 25, 24, 24);
                        }
                    while(++k4 <= 15);
                } while(++k <= 15);
                xword[R][C] += 10;
                repaint((C - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                if(xword[R - 1][C] % 10 + xword[R + 1][C] % 10 == 0)
                    Across = true;
                if(xword[R][C - 1] % 10 + xword[R][C + 1] % 10 == 0)
                    Across = false;
                if((xword[R][C] % 10000) / 100 > 0 && (R1 != R || C1 != C))
                    if(xword[R][C - 1] % 10 == 0 && xword[R][C + 1] % 10 == 1)
                        Across = true;
                    else
                        Across = false;
                if(Across)
                {
                    for(int l = 1; xword[R][C + l] % 10 == 1; l++)
                    {
                        xword[R][C + l] += 20;
                        repaint(((C + l) - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                    }

                    for(int i1 = 1; xword[R][C - i1] % 10 == 1; i1++)
                    {
                        xword[R][C - i1] += 20;
                        repaint((C - i1 - 1) * 24, (R - 1) * 24 + 25, 24, 24);
                    }

                } else
                {
                    for(int j1 = 1; xword[R + j1][C] % 10 == 1; j1++)
                    {
                        xword[R + j1][C] += 20;
                        repaint((C - 1) * 24, ((R + j1) - 1) * 24 + 25, 24, 24);
                    }

                    for(int k1 = 1; xword[R - k1][C] % 10 == 1; k1++)
                    {
                        xword[R - k1][C] += 20;
                        repaint((C - 1) * 24, (R - k1 - 1) * 24 + 25, 24, 24);
                    }

                }
                repaint(0, 386, 360, 49);
            } else
            {
                R = R1;
                C = C1;
            }
            break;

        case 1: // '\001'
        case 2: // '\002'
            int j5 = (j - 25) / 16;
            int k5 = drawMode - 1;
            i = 0;
            int l5 = getClueNum(j5, k5);
            if(l5 <= 0)
                break;
            C1 = C;
            R1 = R;
            R = getRC(l5 % 100) / 100;
            C = getRC(l5 % 100) % 100;
            int i2 = 1;
            do
            {
                int l4 = 1;
                do
                    if((xword[i2][l4] % 100) / 10 > 0)
                        xword[i2][l4] -= ((xword[i2][l4] % 100) / 10) * 10;
                while(++l4 <= 15);
            } while(++i2 <= 15);
            xword[R][C] += 10;
            if(k5 == 0)
                Across = true;
            else
                Across = false;
            if(Across)
            {
                for(int j2 = 1; xword[R][C + j2] % 10 == 1; j2++)
                {
                    if((xword[R][C + j2] % 100) / 10 > 0)
                        xword[R][C + j2] -= ((xword[R][C + j2] % 100) / 10) * 10;
                    xword[R][C + j2] += 20;
                }

                for(int k2 = 1; xword[R][C - k2] % 10 == 1; k2++)
                {
                    if((xword[R][C - k2] % 100) / 10 > 0)
                        xword[R][C - k2] -= ((xword[R][C - k2] % 100) / 10) * 10;
                    xword[R][C - k2] += 20;
                }

            } else
            {
                for(int l2 = 1; xword[R + l2][C] % 10 == 1; l2++)
                {
                    if((xword[R + l2][C] % 100) / 10 > 0)
                        xword[R + l2][C] -= ((xword[R + l2][C] % 100) / 10) * 10;
                    xword[R + l2][C] += 20;
                }

                for(int i3 = 1; xword[R - i3][C] % 10 == 1; i3++)
                {
                    if((xword[R - i3][C] % 100) / 10 > 0)
                        xword[R - i3][C] -= ((xword[R - i3][C] % 100) / 10) * 10;
                    xword[R - i3][C] += 20;
                }

            }
            repaint(0, j5 * 16 + 3 + 25, 360, 16);
            repaint(0, l1 * 16 + 3 + 25, 360, 16);
            l1 = j5;
            repaint(0, 386, 360, 45);
            repaint(0, 25, 360, 20);
            if(event.clickCount > 1)
            {
                drawMode = 0;
                repaint();
            }
            break;

        case 5: // '\005'
            R1 = R;
            C1 = C;
            R = (j - 25) / 24 + 1;
            C = i / 24 + 1;
            if(xword[R][C] % 10 == 1)
            {
                int j3 = 1;
                do
                {
                    int i5 = 1;
                    do
                        if((xword[j3][i5] % 100) / 10 > 0)
                            xword[j3][i5] -= ((xword[j3][i5] % 100) / 10) * 10;
                    while(++i5 <= 15);
                } while(++j3 <= 15);
                xword[R][C] += 10;
                if(xword[R - 1][C] % 10 + xword[R + 1][C] % 10 == 0)
                    Across = true;
                if(xword[R][C - 1] % 10 + xword[R][C + 1] % 10 == 0)
                    Across = false;
                if((xword[R][C] % 10000) / 100 > 0 && (R1 != R || C1 != C))
                    if(xword[R][C - 1] % 10 == 0 && xword[R][C + 1] % 10 == 1)
                        Across = true;
                    else
                        Across = false;
                if(Across)
                {
                    for(int k3 = 1; xword[R][C + k3] % 10 == 1; k3++)
                        xword[R][C + k3] += 20;

                    for(int l3 = 1; xword[R][C - l3] % 10 == 1; l3++)
                        xword[R][C - l3] += 20;

                } else
                {
                    for(int i4 = 1; xword[R + i4][C] % 10 == 1; i4++)
                        xword[R + i4][C] += 20;

                    for(int j4 = 1; xword[R - j4][C] % 10 == 1; j4++)
                        xword[R - j4][C] += 20;

                }
                drawMode = 0;
                repaint();
            } else
            {
                R = R1;
                C = C1;
            }
            break;
        }
        repaint(365, 25, 245, 360);
        return true;
    }

    public int getRC(int i)
    {
        int j = 1;
        do
        {
            int k = 1;
            do
                if((xword[j][k] % 10000) / 100 == i)
                    return j * 100 + k;
            while(++k <= 15);
        } while(++j <= 15);
        return 0;
    }

    public String getParamName(String s)
    {
        String s1 = new String("");
        if(s == null)
            return "";
        for(int i = 0; i < s.length(); i++)
        {
            char c = s.charAt(i);
            if(c >= 'A' && c <= 'Z' || c >= 'a' && c <= 'z')
            {
                Character character = new Character((char)(c - 1));
                s1 = s1 + character.toString();
            }
        }

        return s1;
    }

    public boolean clueDone(int i)
    {
        int j = getRC(i % 100) / 100;
        int k = getRC(i % 100) % 100;
        if(i / 100 == 0)
        {
            for(int l = 0; xword[j][k + l] % 10 != 0; l++)
                if(xword[j][k + l] / 10000 == 0)
                    return false;

        } else
        {
            for(int i1 = 0; xword[j + i1][k] % 10 != 0; i1++)
                if(xword[j + i1][k] / 10000 == 0)
                    return false;

        }
        return true;
    }

    public String getGrid()
    {
        StringBuffer stringbuffer = new StringBuffer("");
        int i = 1;
        do
        {
            int j = 1;
            do
                if(xword[i][j] / 10000 > 0)
                {
                    Character character = new Character((char)(xword[i][j] / 10000));
                    stringbuffer.append(character.toString().toUpperCase());
                } else
                {
                    Character character1 = new Character((char)(xword[i][j] % 10 + 48));
                    stringbuffer.append(character1.toString().toUpperCase());
                }
            while(++j <= 15);
        } while(++i <= 15);
        String s = new String(stringbuffer);
        return s;
    }

    public void makeXWordArray(String s)
    {
        int i = 1;
        do
        {
            int j = 1;
            do
            {
                char c = s.charAt(((i - 1) * 15 + j) - 1);
                if(c == '0')
                    xword[i][j] = 0;
                else
                if(c == '1')
                    xword[i][j] = 1;
                else
                    xword[i][j] = c * 10000 + 1;
            } while(++j <= 15);
        } while(++i <= 15);
        i = 0;
        do
            xword[0][i] = xword[i][0] = xword[16][i] = xword[i][16] = 0;
        while(++i < 17);
        numberXWord();
    }

    public void drawMessageArea(Graphics g, int i)
    {
        g.setColor(Color.white.brighter());
        g.fillRect(0, 386, 360, 49);
        g.setColor(Color.black.brighter());
        g.drawRect(0, 387, 360, 48);
        g.setFont(bigclueF);
        switch(drawMode)
        {
        case 0: // '\0'
        case 1: // '\001'
        case 2: // '\002'
            g.drawString(getClueTitle(), 5, 402);
            g.drawString(getClueSubString(getClueText(), 1, 40), 75, 402);
            g.drawString(getClueSubString(getClueText(), 2, 40), 75, 417);
            g.drawString(getClueSubString(getClueText(), 3, 40), 75, 432);
            return;

        case 3: // '\003'
            return;

        case 5: // '\005'
            if(i == -1)
            {
                g.drawString("The solutions are not available yet", 5, 417);
                return;
            }
            String s;
            if(i != 1)
                s = new String("s.");
            else
                s = new String(".");
            g.drawString("You have " + i + " error" + s, 5, 402);
            if(i == 0)
            {
                g.drawString("CONGRATULATIONS", 5, 417);
                return;
            }
            if(i == 1)
            {
                g.drawString("Only one error - bad luck!", 5, 417);
                return;
            }
            if(i < 10)
            {
                g.drawString("Not many errors - good effort!", 5, 417);
                return;
            } else
            {
                g.drawString("Still got some work to do...", 5, 417);
                return;
            }

        case 4: // '\004'
        default:
            return;
        }
    }

    public String decode(String s)
    {
        String s1 = "";
        String s2 = "";
        if(s == null)
            return null;
        for(int i = s.length() - 1; i >= 0; i--)
        {
            int k = s.charAt(i);
            Character character = new Character((char)k);
            s2 = s2 + character.toString();
        }

        for(int j = 1; j <= s.length(); j++)
        {
            int l = ((s2.charAt(j - 1) - 65 - j * j * j - 3 * j * j - 3 * j - 1) + 1352) % 26 + 65;
            Character character1 = new Character((char)l);
            s1 = s1 + character1.toString();
        }

        System.out.println("ct=" + s + " pt=" + s1);
        return s1;
    }

    public String getAppletInfo(){
        return "CrosswordApplet";
    }

    public int check(Graphics g)
    {
        int j1 = 0;
        g.setColor(Color.red.brighter());
        int i = 1;
        do
        {
            int l = getRC(i) / 100;
            int i1 = getRC(i) % 100;
            String s = stripNonAlpha(answer[i][0]);
            if(answer[i][0] != null)
            {
                for(int j = 0; j < s.length(); j++)
                {
                    int k1 = xword[l][i1 + j] / 10000;
                    if(k1 > 90)
                        k1 -= 32;
                    if(s.charAt(j) != k1)
                    {
                        if(answer[i][1] == null && j == 0 && answer[getClueCode(l, i1 + j, false) - 100][1] == null)
                            j1++;
                        else
                        if(getClueCode(l, i1 + j, false) == 100)
                            j1++;
                        g.drawLine(((i1 - 1) + j) * 24 + 3, (l - 1) * 24 + 25 + 3, (i1 + j) * 24 - 3, (l * 24 + 25) - 3);
                        g.drawLine((i1 + j) * 24 - 3, (l - 1) * 24 + 25 + 3, ((i1 - 1) + j) * 24 + 3, (l * 24 + 25) - 3);
                    }
                }

            }
            s = stripNonAlpha(answer[i][1]);
            if(answer[i][1] != null)
            {
                for(int k = 0; k < s.length(); k++)
                {
                    int i2 = xword[l + k][i1] / 10000;
                    if(i2 > 90)
                        i2 -= 32;
                    if(s.charAt(k) != i2)
                    {
                        j1++;
                        g.drawLine((i1 - 1) * 24 + 3, ((l - 1) + k) * 24 + 25 + 3, i1 * 24 - 3, ((l + k) * 24 + 25) - 3);
                        g.drawLine(i1 * 24 - 3, ((l - 1) + k) * 24 + 25 + 3, (i1 - 1) * 24 + 3, ((l + k) * 24 + 25) - 3);
                    }
                }

            }
        } while(++i < 40);
        return j1;
    }

    public int getClueCode(int i, int j, boolean flag)
    {
        if(i * j == 0)
            return 0;
        int k = 1;
        if(flag)
        {
            for(; xword[i][j - k] % 10 != 0; k++);
            return (xword[i][(j - k) + 1] % 10000) / 100;
        }
        for(; xword[i - k][j] % 10 != 0; k++);
        return (xword[(i - k) + 1][j] % 10000) / 100 + 100;
    }

    public Crossword()
    {
        ShowAnswers = true;
        Across = true;
        overMode = -1;
        numberF = new Font("TimesRoman", 0, 9);
        smallF = new Font("TimesRoman", 0, 10);
        clueF = new Font("TimesRoman", 0, 11);
        clueDoneF = new Font("TimesRoman", 1, 12);
        bigclueF = new Font("TimesRoman", 0, 15);
        letterF = new Font("Courier", 1, 18);
        bigF = new Font("Courier", 1, 30);
        buttonF = new Font("TimesRoman", 0, 12);
        sbuttonF = new Font("TimesRoman", 0, 11);
        ClueListAcross = true;
    }

    public void drawXWord(Graphics g)
    {
        g.drawRect(0, 25, 360, 360);
        g.setColor(Color.white.brighter());
        g.fillRect(0, 0, 361, 25);
        if(drawMode == 1)
            g.setColor(Color.gray.brighter());
        else
            g.setColor(Color.white.brighter());
        g.fillRoundRect(0, 0, 72, 30, 7, 7);
        if(overMode == 1)
            g.setColor(Color.red.brighter());
        else
            g.setColor(Color.black.brighter());
        g.setFont(buttonF);
        g.drawString("CLUES", 5, 11);
        g.setFont(sbuttonF);
        g.drawString("Across", 5, 21);
        if(drawMode == 2)
            g.setColor(Color.gray.brighter());
        else
            g.setColor(Color.white.brighter());
        g.fillRoundRect(72, 0, 72, 30, 7, 7);
        g.setFont(buttonF);
        if(overMode == 2)
            g.setColor(Color.red.brighter());
        else
            g.setColor(Color.black.brighter());
        g.drawString("CLUES", 77, 11);
        g.setFont(sbuttonF);
        g.drawString("Down", 77, 21);
        if(drawMode == 0)
            g.setColor(Color.black.brighter());
        else
            g.setColor(Color.white.brighter());
        g.fillRoundRect(144, 0, 48, 30, 7, 7);
        g.setFont(buttonF);
        if(drawMode == 0)
            g.setColor(Color.white.brighter());
        else
            g.setColor(Color.black.brighter());
        if(overMode == 0)
            g.setColor(Color.red.brighter());
        g.drawString("GRID", 149, 11);
        if(overMode == 0)
            g.setColor(Color.red.brighter());
        else
            g.setColor(Color.black.brighter());
        if(drawMode == 5)
            g.setColor(Color.gray.brighter());
        else
            g.setColor(Color.white.brighter());
        g.fillRoundRect(240, 0, 60, 30, 7, 7);
        g.setFont(buttonF);
        if(overMode == 5)
            g.setColor(Color.red.brighter());
        else
            g.setColor(Color.black.brighter());
        g.drawString("CHECK", 245, 11);
        g.setFont(sbuttonF);
        g.drawString("Solution", 245, 21);
        if(drawMode == 3)
            g.setColor(Color.gray.brighter());
        else
            g.setColor(Color.white.brighter());
        g.fillRoundRect(300, 0, 60, 30, 7, 7);
        g.setFont(buttonF);
        if(overMode == 3)
            g.setColor(Color.red.brighter());
        else
            g.setColor(Color.black.brighter());
        g.drawString("HELP", 305, 11);
        g.setFont(sbuttonF);
        g.drawString("User Guide", 305, 21);
        g.setColor(Color.black.brighter());
        g.drawRoundRect(0, 0, 72, 30, 7, 7);
        g.drawRoundRect(72, 0, 72, 30, 7, 7);
        g.drawRoundRect(144, 0, 48, 30, 7, 7);
        g.drawRoundRect(240, 0, 60, 30, 7, 7);
        g.drawRoundRect(300, 0, 60, 30, 7, 7);
        switch(drawMode)
        {
        case 4: // '\004'
        default:
            break;

        case 0: // '\0'
            int i = 1;
            do
            {
                int k = 1;
                do
                    if(xword[i][k] % 10 == 0)
                        drawBlackSquare(g, i, k, true);
                    else
                    if(xword[i][k] % 10 == 1)
                        drawWhiteSquare(g, i, k, true);
                while(++k <= 15);
            } while(++i <= 15);
            g.setColor(Color.black.brighter());
            g.drawRect(0, 25, 360, 360);
            drawMessageArea(g, 0);
            break;

        case 1: // '\001'
        case 2: // '\002'
            g.setFont(clueF);
            g.setColor(Color.gray.brighter());
            g.fillRect(0, 25, 360, 360);
            g.setColor(Color.black.brighter());
            g.drawRect(0, 25, 360, 360);
            g.setColor(Color.gray.brighter());
            g.drawLine(1 + (drawMode - 1) * 72, 25, drawMode * 72 - 1, 25);
            int i1 = 0;
            if(drawMode == 1)
            {
                g.setColor(Color.black.brighter());
                int k1 = 1;
                do
                    if(clue[k1][0] != null)
                    {
                        i1++;
                        if(getClueCode(R, C, Across) == k1)
                        {
                            g.setColor(Color.red.brighter());
                            g.setFont(clueDoneF);
                        } else
                        {
                            g.setColor(Color.black.brighter());
                            g.setFont(clueF);
                        }
                        if(clueDone(k1))
                        {
                            FontMetrics fontmetrics = g.getFontMetrics();
                            g.drawLine(2, (i1 * 16 + 14 + 25) - 2, fontmetrics.stringWidth(trunc(clue[k1][0])) + 16, (i1 * 16 + 14 + 25) - 2);
                        }
                        g.drawString(k1 + ".", 2, i1 * 16 + 16 + 25);
                        g.drawString(trunc(clue[k1][0]), 20, i1 * 16 + 16 + 25);
                    }
                while(++k1 < 40);
                i1 = 0;
                g.setColor(Color.black.brighter());
            } else
            if(drawMode == 2)
            {
                g.setColor(Color.black.brighter());
                int i2 = 1;
                do
                    if(clue[i2][1] != null)
                    {
                        i1++;
                        if(getClueCode(R, C, Across) - 100 == i2)
                        {
                            g.setColor(Color.red.brighter());
                            g.setFont(clueDoneF);
                        } else
                        {
                            g.setColor(Color.black.brighter());
                            g.setFont(clueF);
                        }
                        if(clueDone(i2 + 100))
                        {
                            FontMetrics fontmetrics1 = g.getFontMetrics();
                            g.drawLine(2, (i1 * 16 + 14 + 25) - 2, fontmetrics1.stringWidth(trunc(clue[i2][1])) + 16, (i1 * 16 + 14 + 25) - 2);
                        }
                        g.drawString(i2 + ".", 2, i1 * 16 + 16 + 25);
                        g.drawString(trunc(clue[i2][1]), 20, i1 * 16 + 16 + 25);
                    }
                while(++i2 < 40);
            }
            String s;
            if(guessMode == 0)
                s = new String(getClueGuess());
            else
                s = new String(getAnswer());
            if(s != null)
            {
                int i3 = s.length();
                g.setFont(letterF);
                for(int j2 = 1; j2 <= i3; j2++)
                {
                    if(guessMode == 0)
                        g.setColor(Color.white.brighter());
                    else
                        g.setColor(Color.gray.brighter());
                    g.fillRect(360 - j2 * 18 - 3, 27, 18, 18);
                    g.setColor(Color.black.brighter());
                    g.drawRect(360 - j2 * 18 - 3, 27, 18, 18);
                    if(guessMode == 1)
                        g.setColor(Color.red.brighter());
                    Character character = new Character(s.charAt(i3 - j2));
                    String s1 = new String(character.toString().toUpperCase());
                    g.drawString(s1, ((360 - j2 * 18) + 3) - 3, 42);
                }

            }
            guessMode = 0;
            g.setColor(Color.white.brighter());
            g.fillRect(0, 386, 360, 49);
            g.setColor(Color.black.brighter());
            g.drawRect(0, 387, 360, 48);
            g.setFont(bigclueF);
            if(comment == 0)
                drawMessageArea(g, 0);
            comment = 0;
            break;

        case 3: // '\003'
            g.setColor(Color.gray.brighter());
            g.fillRect(0, 25, 360, 360);
            g.setColor(Color.black.brighter());
            g.drawRect(0, 25, 360, 360);
            g.setColor(Color.gray.brighter());
            g.drawLine(301, 25, 359, 25);
            g.setFont(buttonF);
            g.setColor(Color.blue.brighter());
            g.setFont(letterF);
            g.drawString("Interactive Crosswords", 10, 43);
            g.setFont(buttonF);
            g.drawString("Click on a square in the Java applet to enter text.", 10, 79);
            g.drawString("Click again to change from Across to Down.", 10, 91);
            g.drawString("The CHECK tab is used to validate your solution.  X's will", 10, 163);
            g.drawString("appear in place of incorrect entries.", 10, 175);
            drawMessageArea(g, 0);
            break;

        case 5: // '\005'
            int j = 1;
            do
            {
                int l = 1;
                do
                    if(xword[j][l] % 10 == 0)
                        drawBlackSquare(g, j, l, false);
                    else
                    if(xword[j][l] % 10 == 1)
                        drawWhiteSquare(g, j, l, false);
                while(++l <= 15);
            } while(++j <= 15);
            g.drawRect(0, 25, 360, 360);
            g.setColor(Color.black.brighter());
            g.drawRect(0, 25, 360, 360);
            g.setColor(Color.gray.brighter());
            g.drawLine(241, 25, 299, 25);
            int j3 = -1;
            if(!NoCurrentAnswer)
                j3 = check(g);
            drawMessageArea(g, j3);
            break;
        }
        int j1 = 0;
        g.setColor(Color.white.brighter());
        g.fillRect(361, 0, 250, 435);
        if(ClueListAcross)
            g.setColor(Color.white.brighter());
        else
            g.setColor(Color.gray.brighter());
        g.fillRoundRect(365, 0, 72, 30, 7, 7);
        if(overMode == 6)
            g.setColor(Color.red.brighter());
        else
            g.setColor(Color.black.brighter());
        g.setFont(buttonF);
        g.drawString("CLUES", 367, 11);
        g.setFont(sbuttonF);
        g.drawString("Across", 367, 21);
        if(!ClueListAcross)
            g.setColor(Color.white.brighter());
        else
            g.setColor(Color.gray.brighter());
        g.fillRoundRect(437, 0, 72, 30, 7, 7);
        g.setFont(buttonF);
        if(overMode == 7)
            g.setColor(Color.red.brighter());
        else
            g.setColor(Color.black.brighter());
        g.drawString("CLUES", 439, 11);
        g.setFont(sbuttonF);
        g.drawString("Down", 439, 21);
        g.setColor(Color.black.brighter());
        g.drawRoundRect(365, 0, 72, 30, 7, 7);
        g.drawRoundRect(437, 0, 72, 30, 7, 7);
        g.setColor(Color.white.brighter());
        g.fillRect(365, 25, 250, 435);
        g.setColor(Color.black.brighter());
        g.drawRect(365, 25, 245, 410);
        g.setColor(Color.white.brighter());
        if(ClueListAcross)
            g.drawLine(366, 25, 437, 25);
        else
            g.drawLine(438, 25, 509, 25);
        if(ClueListAcross)
        {
            g.setColor(Color.black.brighter());
            int k2 = 1;
            do
                if(clue[k2][0] != null)
                {
                    j1++;
                    if(getClueCode(R, C, Across) == k2)
                    {
                        g.setColor(Color.red.brighter());
                        g.setFont(smallF);
                    } else
                    {
                        g.setColor(Color.black.brighter());
                        g.setFont(smallF);
                    }
                    if(clueDone(k2))
                    {
                        FontMetrics fontmetrics2 = g.getFontMetrics();
                        g.drawLine(367, j1 * 10 + 25, fontmetrics2.stringWidth(getClueSubString(clue[k2][0], 1, 50)) + 2 + 360 + 5, j1 * 10 + 25);
                    }
                    g.drawString(k2 + ".", 367, j1 * 10 + 25 + 2);
                    g.drawString(getClueSubString(clue[k2][0], 1, 55), 380, j1 * 10 + 25 + 2);
                    if(clue[k2][0].length() > 55)
                    {
                        j1++;
                        g.drawString(getClueSubString(clue[k2][0], 2, 55), 380, j1 * 10 + 25 + 2);
                        if(clueDone(k2))
                        {
                            FontMetrics fontmetrics3 = g.getFontMetrics();
                            g.drawLine(380, j1 * 10 + 25, fontmetrics3.stringWidth(getClueSubString(clue[k2][0], 2, 50)) + 2 + 360 + 5, j1 * 10 + 25);
                        }
                    }
                }
            while(++k2 < 40);
            j1 = 0;
            g.setColor(Color.black.brighter());
        } else
        {
            g.setColor(Color.black.brighter());
            int l2 = 1;
            do
                if(clue[l2][1] != null)
                {
                    j1++;
                    if(getClueCode(R, C, Across) - 100 == l2)
                    {
                        g.setColor(Color.red.brighter());
                        g.setFont(smallF);
                    } else
                    {
                        g.setColor(Color.black.brighter());
                        g.setFont(smallF);
                    }
                    if(clueDone(l2 + 100))
                    {
                        FontMetrics fontmetrics4 = g.getFontMetrics();
                        g.drawLine(367, j1 * 10 + 25, fontmetrics4.stringWidth(getClueSubString(clue[l2][1], 1, 50)) + 2 + 360 + 5, j1 * 10 + 25);
                    }
                    g.drawString(l2 + ".", 367, j1 * 10 + 25 + 2);
                    g.drawString(getClueSubString(clue[l2][1], 1, 55), 380, j1 * 10 + 25 + 2);
                    if(clue[l2][1].length() > 55)
                    {
                        j1++;
                        g.drawString(getClueSubString(clue[l2][1], 2, 55), 380, j1 * 10 + 25 + 2);
                        if(clueDone(l2 + 100))
                        {
                            FontMetrics fontmetrics5 = g.getFontMetrics();
                            g.drawLine(380, j1 * 10 + 25, fontmetrics5.stringWidth(getClueSubString(clue[l2][1], 2, 50)) + 2 + 360 + 5, j1 * 10 + 25);
                        }
                    }
                }
            while(++l2 < 40);
        }
        g.drawImage(ad, 365, 385, this);
    }

    public void numberXWord()
    {
        int k = 1;
        int i = 1;
        do
        {
            int j = 1;
            do
                if(xword[i][j] % 10 == 1)
                    if(xword[i][j - 1] % 10 == 0 && xword[i][j + 1] % 10 == 1)
                    {
                        xword[i][j] += k * 100;
                        k++;
                    } else
                    if(xword[i - 1][j] % 10 == 0 && xword[i + 1][j] % 10 == 1)
                    {
                        xword[i][j] += k * 100;
                        k++;
                    }
            while(++j <= 15);
        } while(++i <= 15);
    }

    public void run()
    {
    }

    public String getClueText()
    {
        StringBuffer stringbuffer = new StringBuffer("");
        if(R * C == 0)
            return "";
        int i = 1;
        if(Across)
        {
            for(; xword[R][C - i] % 10 != 0; i++);
            stringbuffer.append(clue[(xword[R][(C - i) + 1] % 10000) / 100][0]);
        } else
        {
            for(; xword[R - i][C] % 10 != 0; i++);
            stringbuffer.append(clue[(xword[(R - i) + 1][C] % 10000) / 100][1]);
        }
        String s = new String(stringbuffer);
        return s;
    }

    public int getClueNum(int i, int j)
    {
        int l = 0;
        if(i < 1 || i > nac && j == 0 || i > ndc && j == 1)
            return 0;
        int k = 1;
        do
        {
            if(clue[k][j] != null)
                l++;
            if(l == i)
                return j * 100 + k;
        } while(++k < 40);
        return 0;
    }

    public void drawWhiteSquare(Graphics g, int i, int j, boolean flag)
    {
        if((xword[i][j] % 100) / 10 == 1)
            g.setColor(Color.yellow.brighter());
        else
        if((xword[i][j] % 100) / 10 == 2)
            g.setColor(Color.gray.brighter());
        else
        if((xword[i][j] % 100) / 10 == 3)
            g.setColor(Color.gray.darker());
        else
            g.setColor(Color.white.brighter());
        if(!flag)
            g.setColor(Color.white.brighter());
        g.fillRect((j - 1) * 24, (i - 1) * 24 + 25, 24, 24);
        g.setColor(Color.black.brighter());
        if(!flag)
            g.setColor(Color.gray.brighter());
        g.drawRect((j - 1) * 24, (i - 1) * 24 + 25, 24, 24);
        setColour( g );
        if(!flag)
            g.setColor(Color.gray.brighter());
        g.setFont(numberF);
        if((xword[i][j] / 100) % 100 > 0)
            g.drawString(String.valueOf((xword[i][j] / 100) % 100), (j - 1) * 24 + 2, (i - 1) * 24 + 25 + 9);
        g.setFont(letterF);
        if(xword[i][j] / 10000 > 0)
        {
            g.setColor(Color.blue.brighter());
            if(!flag)
                g.setColor(Color.gray.brighter());
            Character character = new Character((char)(xword[i][j] / 10000));
            String s = new String(character.toString().toUpperCase());
            g.drawString(s, (j - 1) * 24 + (24 - g.getFontMetrics().stringWidth(s)) / 2 + 1, (i - 1) * 24 + 25 + 19);
        }
    }

    public void drawBlackSquare(Graphics g, int i, int j, boolean flag)
    {
        setColour( g );
        if(!flag)
            g.setColor(Color.gray.brighter());
        g.drawRect((j - 1) * 24 + 1, (i - 1) * 24 + 25 + 1, 24, 24);
        g.fillRect((j - 1) * 24 + 1, (i - 1) * 24 + 25 + 1, 24, 24);
    }

    public void destroy()
    {
    }

    public void init()
    {
        try
        {
            URL url = new URL(getParameter("AdvertGif"));
            ad = getImage(url);
        }
        catch(Exception _ex)
        {
            System.exit(1);
        }
        xword = new int[17][17];
        clue = new String[40][2];
        answer = new String[40][2];
        drawMode = 0;
        comment = 0;
        guessMode = 0;
        Grid = getParameter("Grid");
        answers = false;
        thestr = new String(" BETA  VERSION ");
        nac = ndc = 0;
        int i = 1;
        do
        {
            String s = i + "A";
            clue[i][0] = getParameter(s);
            s = i + "AA";
            answer[i][0] = getParameter(s);
            if(clue[i][0] != null)
                nac++;
            s = i + "D";
            clue[i][1] = getParameter(s);
            s = i + "DA";
            answer[i][1] = getParameter(s);
            if(clue[i][1] != null)
                ndc++;
            if(answer[i][0] != null)
                answer[i][0] = answer[i][0].toUpperCase();
            if(answer[i][1] != null)
                answer[i][1] = answer[i][1].toUpperCase();
        } while(++i < 40);
        colour = 0;
        makeXWordArray(Grid);
        requestFocus();
        resize(610, 435);
    }

    public void paint(Graphics g)
    {
        drawXWord(g);
    }

    public String getAnswer()
    {
        if(R * C == 0)
            return "";
        if(answer[getClueCode(R, C, Across) % 100][getClueCode(R, C, Across) / 100] == null)
            return "";
        else
            return stripNonAlpha(answer[getClueCode(R, C, Across) % 100][getClueCode(R, C, Across) / 100]);
    }

    private boolean UC;
    private boolean ShowAnswers;
    private String thestr;
    private boolean Across;
    private Image ad;
    private int xword[][];
    private String clue[][];
    private String answer[][];
    private int nac;
    private int ndc;
    private int drawMode;
    private int overMode;
    private int guessMode;
    private int comment;
    private boolean NoCurrentAnswer;
    private boolean answers;
    private int R;
    private int R1;
    private int C;
    private int C1;
    private int l1;
    private Font numberF;
    private Font smallF;
    private Font clueF;
    private Font clueDoneF;
    private Font bigclueF;
    private Font letterF;
    private Font bigF;
    private Font buttonF;
    private Font sbuttonF;
    private String Grid;
    private int colour;
    private boolean ClueListAcross;
}