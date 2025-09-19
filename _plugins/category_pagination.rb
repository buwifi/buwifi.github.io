# _plugins/category_pagination.rb
module Jekyll
  class TaxonomyPageGenerator < Generator
    safe true

    def generate(site)
      generate_taxonomy_pages(site, "categories", site.categories)
      generate_taxonomy_pages(site, "tags", site.tags)
    end

    private

    def generate_taxonomy_pages(site, type, items)
      items.each do |name, posts|
        next if posts.empty?

        per_page = site.config.dig("pagination", "per_page") || 4
        total_pages = (posts.size.to_f / per_page).ceil

        (1..total_pages).each do |page_num|
          site.pages << TaxonomyPage.new(
            site, site.source, type, name, posts, page_num, per_page, total_pages
          )
        end
      end
    end
  end

  class TaxonomyPage < Page
    attr_reader :paginator

    def initialize(site, base, type, name, posts, page_num, per_page, total_pages)
      @site = site
      @base = base
      @dir  = page_num == 1 ? "#{type}/#{name}" : "#{type}/#{name}/page#{page_num}"
      @name = "index.html"

      self.process(@name)

      # pick correct layout file
      layout_file =
        case type
        when "categories" then "category_index.html"
        when "tags"       then "tag_index.html"
        else "index.html"
        end

      self.read_yaml(File.join(base, "_layouts"), layout_file)

      # Set metadata for use in templates
      self.data["title"] = name.capitalize
      self.data["type"]  = (type == "categories" ? "category" : "tag")
      self.data[self.data["type"]] = name

      # Paginator object
      self.data["paginator"] = {
        "page"              => page_num,
        "per_page"          => per_page,
        "posts"             => posts.slice((page_num - 1) * per_page, per_page) || [],
        "total_posts"       => posts.size,
        "total_pages"       => total_pages,
        "previous_page"     => page_num > 1 ? page_num - 1 : nil,
        "next_page"         => page_num < total_pages ? page_num + 1 : nil,
        "previous_page_path" =>
          if page_num > 2
            "/#{type}/#{name}/page#{page_num - 1}/"
          elsif page_num == 2
            "/#{type}/#{name}/"
          else
            nil
          end,
        "next_page_path" =>
          if page_num < total_pages
            "/#{type}/#{name}/page#{page_num + 1}/"
          else
            nil
          end
      }
    end
  end
end
